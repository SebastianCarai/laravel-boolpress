<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Nuovo messaggio da un contatto</h1>

    <h3> <strong>Email:</strong> {{$new_contact->email}} </h3>
    <h3> <strong>Name:</strong> {{$new_contact->name}} </h3>
    <p> <strong>Content:</strong> {{$new_contact->content}} </p>
</body>
</html>