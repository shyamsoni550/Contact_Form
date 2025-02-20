<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <!-- Link Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="./index.css">
</head>
<body>
    <div class="container mt-5">
        <div class="contact-card">
            <h2 class="text-center mb-4">Contact Us</h2>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'username_exists'): ?>
                <div class="alert alert-danger" role="alert">
                    Username already exists! Please choose a different username.
                </div>
            <?php endif; ?>
            <form action="./submit.php" method="POST">

                <div class="mb-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" placeholder="Enter Your Name" id="name" name="username" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Enter Your Email" id="email" name="email" required >
                </div>
                <div class="mb-4">
                    <label for="message" class="form-label">Message</label><br>
                    <textarea class="form-control" id="message" name="message" rows="4" placeholder="Write your message here..." required ></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-dark w-100">Submit</button>

            </form>
        </div>
    </div>
</body>
</html>
