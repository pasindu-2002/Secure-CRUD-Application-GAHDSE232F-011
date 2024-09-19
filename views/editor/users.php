<?php

if (!isset($_SESSION)) {
	session_start();
}

if (!isset($_SESSION['user_id'])) {
	header("Location: /Secure-CRUD/");
	exit; // Ensure script execution stops after redirection
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Bootstrap CRUD Data Table for Database with Modal Form</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<style>
		body {
			color: #566787;
			background: #f5f5f5;
			font-family: 'Varela Round', sans-serif;
			font-size: 13px;
			display: flex;
			min-height: 100vh;
			overflow-x: hidden;

		}

		.table-responsive {
			margin: 30px 0;
		}

		.table-wrapper {
			background: #fff;
			padding: 20px 25px;
			border-radius: 3px;
			min-width: 1000px;
			box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
		}

		.table-title {
			padding-bottom: 15px;
			background: #435d7d;
			color: #fff;
			padding: 16px 30px;
			min-width: 100%;
			margin: -20px -25px 10px;
			border-radius: 3px 3px 0 0;
		}

		.table-title h2 {
			margin: 5px 0 0;
			font-size: 24px;
		}

		.table-title .btn-group {
			float: right;
		}

		.table-title .btn {
			color: #fff;
			float: right;
			font-size: 13px;
			border: none;
			min-width: 50px;
			border-radius: 2px;
			border: none;
			outline: none !important;
			margin-left: 10px;
		}

		.table-title .btn i {
			float: left;
			font-size: 21px;
			margin-right: 5px;
		}

		.table-title .btn span {
			float: left;
			margin-top: 2px;
		}

		table.table tr th,
		table.table tr td {
			border-color: #e9e9e9;
			padding: 12px 15px;
			vertical-align: middle;
		}

		table.table tr th:first-child {
			width: 60px;
		}

		table.table tr th:last-child {
			width: 100px;
		}

		table.table-striped tbody tr:nth-of-type(odd) {
			background-color: #fcfcfc;
		}

		table.table-striped.table-hover tbody tr:hover {
			background: #f5f5f5;
		}

		table.table th i {
			font-size: 13px;
			margin: 0 5px;
			cursor: pointer;
		}

		table.table td:last-child i {
			opacity: 0.9;
			font-size: 22px;
			margin: 0 5px;
		}

		table.table td a {
			font-weight: bold;
			color: #566787;
			display: inline-block;
			text-decoration: none;
			outline: none !important;
		}

		table.table td a:hover {
			color: #2196F3;
		}

		table.table td a.edit {
			color: #FFC107;
		}

		table.table td a.delete {
			color: #F44336;
		}

		table.table td i {
			font-size: 19px;
		}

		table.table .avatar {
			border-radius: 50%;
			vertical-align: middle;
			margin-right: 10px;
		}

		.pagination {
			float: right;
			margin: 0 0 5px;
		}

		.pagination li a {
			border: none;
			font-size: 13px;
			min-width: 30px;
			min-height: 30px;
			color: #999;
			margin: 0 2px;
			line-height: 30px;
			border-radius: 2px !important;
			text-align: center;
			padding: 0 6px;
		}

		.pagination li a:hover {
			color: #666;
		}

		.pagination li.active a,
		.pagination li.active a.page-link {
			background: #03A9F4;
		}

		.pagination li.active a:hover {
			background: #0397d6;
		}

		.pagination li.disabled i {
			color: #ccc;
		}

		.pagination li i {
			font-size: 16px;
			padding-top: 6px
		}

		.hint-text {
			float: left;
			margin-top: 10px;
			font-size: 13px;
		}

		/* Custom checkbox */
		.custom-checkbox {
			position: relative;
		}

		.custom-checkbox input[type="checkbox"] {
			opacity: 0;
			position: absolute;
			margin: 5px 0 0 3px;
			z-index: 9;
		}

		.custom-checkbox label:before {
			width: 18px;
			height: 18px;
		}

		.custom-checkbox label:before {
			content: '';
			margin-right: 10px;
			display: inline-block;
			vertical-align: text-top;
			background: white;
			border: 1px solid #bbb;
			border-radius: 2px;
			box-sizing: border-box;
			z-index: 2;
		}

		.custom-checkbox input[type="checkbox"]:checked+label:after {
			content: '';
			position: absolute;
			left: 6px;
			top: 3px;
			width: 6px;
			height: 11px;
			border: solid #000;
			border-width: 0 3px 3px 0;
			transform: inherit;
			z-index: 3;
			transform: rotateZ(45deg);
		}

		.custom-checkbox input[type="checkbox"]:checked+label:before {
			border-color: #03A9F4;
			background: #03A9F4;
		}

		.custom-checkbox input[type="checkbox"]:checked+label:after {
			border-color: #fff;
		}

		.custom-checkbox input[type="checkbox"]:disabled+label:before {
			color: #b8b8b8;
			cursor: auto;
			box-shadow: none;
			background: #ddd;
		}

		/* Modal styles */
		.modal .modal-dialog {
			max-width: 400px;
		}

		.modal .modal-header,
		.modal .modal-body,
		.modal .modal-footer {
			padding: 20px 30px;
		}

		.modal .modal-content {
			border-radius: 3px;
			font-size: 14px;
		}

		.modal .modal-footer {
			background: #ecf0f1;
			border-radius: 0 0 3px 3px;
		}

		.modal .modal-title {
			display: inline-block;
		}

		.modal .form-control {
			border-radius: 2px;
			box-shadow: none;
			border-color: #dddddd;
		}

		.modal textarea.form-control {
			resize: vertical;
		}

		.modal .btn {
			border-radius: 2px;
			min-width: 100px;
		}

		.modal form label {
			font-weight: normal;
		}

		/* Sidebar Styles */
		#sidebar {
			min-width: 220px;
			max-width: 220px;
			background: #2c3e50;
			color: #ecf0f1;
			transition: all 0.3s;
			font-family: 'Arial', sans-serif;
		}

		#sidebar .sidebar-header {
			padding: 25px;
			background: #34495e;
			text-align: center;
			border-bottom: 1px solid #2c3e50;
		}

		#sidebar .sidebar-header h3 {
			margin: 0;
			font-size: 1.4em;
			font-weight: 600;
			color: #ecf0f1;
		}

		#sidebar ul.components {
			padding: 15px 0;
			list-style: none;
			margin: 0;
		}

		#sidebar ul li {
			padding: 12px 20px;
			font-size: 1.1em;
			display: block;
			transition: all 0.3s;
			border-bottom: 1px solid #2c3e50;
		}

		#sidebar ul li:last-child {
			border-bottom: none;
		}

		#sidebar ul li a {
			color: #bdc3c7;
			display: block;
			text-decoration: none;
			transition: color 0.3s, background 0.3s;
		}

		#sidebar ul li a i {
			margin-right: 10px;
		}

		#sidebar ul li a:hover,
		#sidebar ul li.active>a {
			color: #ecf0f1;
			background: #1abc9c;
			border-radius: 5px;
		}

		#sidebar ul li.active>a {
			background: #16a085;
		}

		/* Content Styles */
		#content {
			width: 100%;
			padding: 30px;
			transition: all 0.3s;
			background: #f8f9fa;
			min-height: 100vh;
		}

		/* Navbar Toggle Button */
		#sidebarCollapse {
			width: 45px;
			height: 45px;
			background: #2c3e50;
			color: #ecf0f1;
			cursor: pointer;
			transition: all 0.3s;
			border: none;
			position: absolute;
			top: 15px;
			left: 15px;
			border-radius: 5px;
		}

		#sidebarCollapse:hover {
			background: #34495e;
		}

		/* Responsive Styles */
		@media (max-width: 768px) {
			#sidebar {
				min-width: 0;
				max-width: 0;
				display: none;
			}

			#sidebar.active {
				min-width: 250px;
				max-width: 250px;
				display: block;
				position: fixed;
				top: 0;
				left: 0;
				height: 100%;
				z-index: 999;
			}

			#content {
				width: 100%;
				padding: 20px;
			}

			#sidebarCollapse {
				display: block;
			}
		}
	</style>
	<script>
		$(document).ready(function () {
			$('#sidebarCollapse').on('click', function () {
				$('#sidebar').toggleClass('active');
			});

			// Activate tooltip
			$('[data-toggle="tooltip"]').tooltip();

			// Select/Deselect checkboxes
			var checkbox = $('table tbody input[type="checkbox"]');
			$("#selectAll").click(function () {
				if (this.checked) {
					checkbox.each(function () {
						this.checked = true;
					});
				} else {
					checkbox.each(function () {
						this.checked = false;
					});
				}
			});
			checkbox.click(function () {
				if (!this.checked) {
					$("#selectAll").prop("checked", false);
				}
			});
		});
	</script>
</head>

<body>
	<!-- Sidebar -->
	<nav id="sidebar">
		<div class="sidebar-header">
			<h3>Dashboard</h3>
		</div>
		<ul class="components">
			<li>
				<a href="http://localhost/Secure-CRUD/public/index.php?action=dashboard_product"><i
						class="fas fa-home"></i> Product</a>
			</li>

			<li class="active">
				<a href="http://localhost/Secure-CRUD/public/index.php?action=dashboard_users"><i
						class="fas fa-user-friends"></i> Users</a>
			</li>
			<li>
				<a href="#"><i class="fas fa-chart-line"></i> Analytics</a>
			</li>
		</ul>
	</nav>

	<div class="container-xl">
		<div class="table-responsive">
			<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-sm-6">
							<h2>Manage <b>Users</b></h2>
						</div>
						<div class="col-sm-6">
							<a href="http://localhost/Secure-CRUD/public/index.php?action=logout"
								class="btn btn-danger">Logout</a>
						</div>



					</div>
				</div>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Role</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$users = $userController->getAllUsers();
						foreach ($users as $user) {
							$status = $user['failed_attempts'] < 3 ? 'Active' : 'Locked';

							$buttonHtml = '';
							if ($status === 'Active') {
								$buttonHtml = '<button class="btn btn-danger" data-user-id="' . htmlspecialchars($user['id']) . '" data-action="lock" onclick="handleAction(this)" data-toggle="tooltip" title="Lock">Lock</button>';
							} else {
								$buttonHtml = '<button class="btn btn-success" data-user-id="' . htmlspecialchars($user['id']) . '" data-action="activate" onclick="handleAction(this)" data-toggle="tooltip" title="Activate">Activate</button>';
							}

							echo '<tr data-user-id="' . htmlspecialchars($user['id']) . '" class="view-details-row">
									<td>' . htmlspecialchars($user['name']) . '</td>
									<td>' . htmlspecialchars($user['email']) . '</td>
									<td>' . htmlspecialchars($user['tele']) . '</td>
									<td>' . htmlspecialchars($user['role']) . '</td>
									<td>' . htmlspecialchars($status) . '</td>
									<td>
										<a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
										<a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
										' . $buttonHtml . '
									</td>
								</tr>';
						}
						?>


						<script>
							function handleAction(button) {
								const userId = button.getAttribute('data-user-id');
								const action = button.getAttribute('data-action');

								fetch('http://localhost/Secure-CRUD/public/index.php?action=updateStatus', {
									method: 'POST',
									headers: {
										'Content-Type': 'application/x-www-form-urlencoded',
									},
									body: `user_id=${encodeURIComponent(userId)}&action=${encodeURIComponent(action)}`
								})
									.then(response => response.text())
									.then(text => {
										console.log('Raw response:', text);
										let data;
										try {
											data = JSON.parse(text);
										} catch (error) {
											console.error('Error parsing JSON:', error);
											alert('An error occurred. Please try again later.');
											return;
										}

										if (data.success) {
											window.location.href = 'http://localhost/Secure-CRUD/public/index.php?action=dashboard_users'; // Redirect to the desired URL
										} else {
											alert('Failed to update user status. Please try again.');
										}
									})
									.catch(error => {
										console.error('Error:', error);
										alert('An error occurred. Please try again later.');
									});
							}
						</script>





					</tbody>
				</table>

			</div>
		</div>
	</div>
	<!-- Add Employee Modal -->
	<div id="addEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="http://localhost/Secure-CRUD/public/index.php?action=register" method="POST">

						<div class="form-group">
							<label>Name</label>
							<input type="text" name="name" class="form-control" placeholder="Enter employee name"
								required>
						</div>

						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Enter employee email"
								required>
						</div>

						<div class="form-group">
							<label>Phone</label>
							<input type="number" name="tele" class="form-control" placeholder="Enter employee Tele No"
								required>
						</div>

						<div class="form-group">
							<label>Password</label>
							<input type="text" name="password" class="form-control"
								placeholder="Enter employee Password" required>
						</div>

						<div class="form-group">
							<label for="role">Role</label>
							<select name="role" class="form-control" name="role" id="role" required>
								<option value="admin">Admin</option>
								<option value="editor">Editor</option>
								<option value="user">User</option>
							</select>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>

					</form>

				</div>

			</div>
		</div>
	</div>

	<!-- Edit Employee Modal -->
	<div id="editEmployeeModal" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Employee</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="editUserForm">
						<input type="hidden" id="editUserId">
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" id="editName">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" id="editEmail">
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" id="editPhone">
						</div>
						<div class="form-group">
							<label>Role</label>
							<select class="form-control" id="editRole">
								<option value="">Select Role</option>
								<option value="admin">Admin</option>
								<option value="user">User</option>
								<option value="manager">Manager</option>
								<!-- Add more roles as needed -->
							</select>
						</div>

						<div class="form-group">
							<label>Status</label>
							<input type="text" class="form-control" id="editStatus">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" id="updateUserBtn" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>



	<script>
		// When 'Edit' button is clicked
		document.addEventListener('DOMContentLoaded', function () {
			document.querySelectorAll('.edit').forEach(button => {
				button.addEventListener('click', function () {
					const row = this.closest('tr');
					// Fetch the user data from the row's cells
					const userId = row.dataset.userId;
					const name = row.querySelector('td:nth-child(1)').textContent.trim();
					const email = row.querySelector('td:nth-child(2)').textContent.trim();
					const phone = row.querySelector('td:nth-child(3)').textContent.trim();
					const role = row.querySelector('td:nth-child(4)').textContent.trim();
					const status = row.querySelector('td:nth-child(5)').textContent.trim();

					// Populate the form in the modal
					document.getElementById('editUserId').value = userId;
					document.getElementById('editName').value = name;
					document.getElementById('editEmail').value = email;
					document.getElementById('editPhone').value = phone;

					// Set the role in the select dropdown
					const roleSelect = document.getElementById('editRole');
					for (let option of roleSelect.options) {
						if (option.value === role) {
							roleSelect.value = option.value;
							break;
						}
					}

					document.getElementById('editStatus').value = status;

					// Show the modal
					$('#editEmployeeModal').modal('show');
				});
			});
		});

		// Handle the form submission for updating user
		document.getElementById('updateUserBtn').addEventListener('click', function (event) {
			event.preventDefault();  // Prevent default button behavior

			const userId = document.getElementById('editUserId').value;
			const userName = document.getElementById('editName').value;
			const userEmail = document.getElementById('editEmail').value;
			const userPhone = document.getElementById('editPhone').value;
			const userRole = document.getElementById('editRole').value;
			const userStatus = document.getElementById('editStatus').value;

			fetch('http://localhost/Secure-CRUD/public/index.php?action=updateUser', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: `id=${encodeURIComponent(userId)}&name=${encodeURIComponent(userName)}&email=${encodeURIComponent(userEmail)}&tele=${encodeURIComponent(userPhone)}&role=${encodeURIComponent(userRole)}&status=${encodeURIComponent(userStatus)}`
			})
				.then(response => response.text())
				.then(text => {
					console.log('Raw response:', text);
					let data;
					try {
						data = JSON.parse(text);
					} catch (error) {
						console.error('Error parsing JSON:', error);
						alert('An error occurred. Please try again later.');
						return;
					}

					if (data.success) {
						$('#editEmployeeModal').modal('hide');  // Close the modal
						window.location.href = 'http://localhost/Secure-CRUD/public/index.php?action=dashboard_users';  // Redirect to the dashboard
					} else {
						alert('Failed to update user. Please try again.');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('An error occurred. Please try again later.');
				});
		});
	</script>



	<!-- Delete Employee Modal -->
	<div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Delete User</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete this user?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
					<input type="hidden" id="deleteUserId">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-danger" id="deleteUserBtn">Delete</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		// When 'Delete' button is clicked, open the modal and set userId
		document.querySelectorAll('.delete').forEach(button => {
			button.addEventListener('click', function () {
				const row = this.closest('tr');
				const userId = row.dataset.userId;
				document.getElementById('deleteUserId').value = userId;
			});
		});

		// Handle delete action
		document.getElementById('deleteUserBtn').addEventListener('click', function () {
			const userId = document.getElementById('deleteUserId').value;
			fetch('http://localhost/Secure-CRUD/public/index.php?action=deleteUser', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
				},
				body: `id=${encodeURIComponent(userId)}`
			})
				.then(response => response.text())  // Capture the response as plain text first
				.then(text => {
					console.log('Raw response:', text);  // Log raw response to debug
					let data;

					// Try to parse JSON response
					try {
						data = JSON.parse(text);
					} catch (error) {
						console.error('Error parsing JSON:', error);
						alert('An error occurred. Please try again later.');
						return;  // Exit if JSON parsing fails
					}

					// Check for success key in parsed data
					console.log('Parsed response:', data);  // Log parsed data for debugging
					if (data.success) {
						$('#deleteEmployeeModal').modal('hide');
						window.location.href = 'http://localhost/Secure-CRUD/public/index.php?action=dashboard_users';
					} else {
						alert('Failed to delete user. Please try again.');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('An error occurred. Please try again later.');
				});
		});


	</script>


</body>

</html>