<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>
    </head>
    <body>
        <h1>Welcome</h1>
        <p><?php echo htmlspecialchars($name); ?></p>

        
        	<?php foreach($posts as $post): ?>
        		<b><?php echo htmlspecialchars($post['title']); ?></b><br />
                <i><?php echo htmlspecialchars($post['content']); ?></i>
        	<?php endforeach; ?>
        

    </body>
</html>