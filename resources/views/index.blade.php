<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <form name="socket-form" action="/" method="post">
            @csrf
            <label for="sockets">Enter IP addresses:</label><br />
            <textarea name="sockets" id="" cols="60" rows="30" id="sockets"></textarea><br />
            <button id="submit">Submit</button>
        </form>
        <?php if ($checker->isProcessed()): ?>
            <h3><?php printf('Working servers: %d / Total checked: %d', $checker->getWorked(), $checker->getTotal()); ?></h3>
            <table>
                <thead>
                    <th>ip:port</th>
                    <th>type</th>
                    <th>country/region</th>
                    <th>status</th>
                    <th>query time</th>
                </thead>
                <tbody>
                    <?php foreach ($checker->getResult() as $socket => $proxy): ?>
                        <tr>
                            <td><?php echo $socket; ?></td>
                            <td><?php echo $proxy->type ?? 'N/A'; ?></td>
                            <td><?php printf('%s/%s', $proxy->country ?? 'N/A', $proxy->region ?? 'N/A'); ?></td>
                            <td><?php echo $proxy->status ?? 'N/A'; ?></td>
                            <td><?php echo $proxy->{'query time'} ?? 'N/A'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </body>
</html>
