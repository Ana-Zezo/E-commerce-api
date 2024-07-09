<html>
<head>
    <title>login</title>
   
</head>


<body>

<form method="post" action={{url("auth/admin/login")}}>
@csrf
<input type="email" name="email">
<input type="password" name="password">
<button type="submit">login</button>
</form>


</body>




</html>