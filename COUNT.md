```
function count(string $location): int
{
    $count = 0;

    if (!file_exists($location)) {
        return $count;
    }

    $getContent = function (string $path): array {
        $path = rtrim($path, '/');
        $content = array_diff(scandir($path), ['.', '..']);

        return array_map(function (string $item) use ($path) {
            return $path . '/' . $item;
        }, $content);
    };

    $walker = function (string $path) use (&$count, $getContent, &$walker): void {
        $type = filetype($path);

        if ($type === 'dir') {
            foreach ($getContent($path) as $item) {
                $walker($item);
            }
        } elseif ($type === 'file' && str_ends_with($path, 'count')) {
            $handle = fopen($path, "r");

            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $count = $count + intval($line);
                }

                fclose($handle);
            }
        }
    };

    $walker($location);

    return $count;
};
```