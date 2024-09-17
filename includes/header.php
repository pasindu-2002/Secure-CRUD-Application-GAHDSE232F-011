<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .header {
            background-color: #435d7d;
            color: #fff;
            padding: 15px 20px;
            border-radius: 0 0 8px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,.1);
        }
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .logout {
            font-size: 16px;
            cursor: pointer;
            color: #fff;
            background-color: #ff4b4b;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .header .logout:hover {
            background-color: #e03e3e;
            transform: scale(1.05);
        }
        .header .logout:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">My Store</div>
        <button class="logout" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </header>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Logout</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to log out?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <a href = "http://localhost/Secure-CRUD/public/index.php?action=logout" class="btn btn-danger" >Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
</body>
</html>
