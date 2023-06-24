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
    setTimeout(() => {
        console.log('first');
        window.Echo.channel('front')
            .listen('.MyWebSocket', (e) => {
                console.log('e', e);
            })
    }, 200);

    
    setTimeout(() => {
        console.log('second');
        window.Echo.channel('front')
            .listen('MyWebSocket', (e) => {
                console.log('e', e);
            })
    }, 200);
</script>

</html>
