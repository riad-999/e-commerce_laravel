<!DOCTYPE html>
<html lang="fr" style="box-sizing: border-box;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vérifivation d'email</title>
</head>

<body style="font-size: 18px;">
    <main style="width: min(90%, 600px);
        margin: 3rem auto;
        padding: 1rem;
        text-align: center;" >
        <h3 style="text-align: center; margin-bottom: 2rem;">vous avez oublié votre mot de pass?</h3>
        <div style="margin-bottom: 2rem; text-align: center;">
            Clickez sur le bouton ci-dessous pour changer votre mot de passe.
        </div>
        <button type="button" style="display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 2rem;
        background-color: black;
        border: none;
        font-weight: 600;
        color: white;
        cursor: pointer;">
            <a href="{{$url}}" style="display: inline-block; color: white; padding: 1rem 2rem 1rem; text-decoration: none;">
                Changer
            </a>
        </button>
    </main>
</body>

</html>