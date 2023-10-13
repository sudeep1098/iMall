 <!-- Modal -->
 <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="/ecommerce/partials/_handleLogin.php" method="post">
                     <div class="mb-3">
                         <label for="login_email" class="form-label">Email address</label>
                         <input type="email" class="form-control" id="login_email" name="login_email" aria-describedby="emailHelp">

                     </div>
                     <div class="mb-3">
                         <label for="login_password" class="form-label">Password</label>
                         <input type="password" class="form-control" id="login_password" name="login_password">
                     </div>
                     <button type="submit" class="btn btn-primary">Login</button>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>