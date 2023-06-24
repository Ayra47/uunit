<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

</body>
@vite('resources/js/app.js')
<script>
    // setTimeout(() => {
    //     window.Echo.channel('front')
    //         .listen('.MyWebSocket', (e) => {
    //             console.log('e', e);
    //         })
    // }, 200);
    console.log('page message');

    // работает с дашбордом
    window.Echo.channel("front").listen(".MyWebSocket", (e) => {
        console.log('first', e);
    });

    // работает с апишкой
    window.Echo.channel("front").listen("MyWebSocket", (e) => {
        console.log('second', e);
    });
</script>

</html>
