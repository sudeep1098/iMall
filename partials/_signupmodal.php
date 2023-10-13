 <!-- Modal -->
 <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="singupModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h1 class="modal-title fs-5" id="singupModalLabel">Signup</h1>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form action="/ecommerce/partials/_handleSignup.php" method="post">
                     <div class="mb-3">
                         <label for="signup_email" class="form-label">Email address</label>
                         <input type="email" class="form-control" id="signup_email" name="signup_email" aria-describedby="emailHelp">

                     </div>
                     <div class="mb-3">
                         <label for="signup_password" class="form-label">Password</label>
                         <input type="password" class="form-control" id="signup_password" name="signup_password">
                     </div>
                     <div class="mb-3">
                         <label for="cPass" class="form-label">Confirm Password</label>
                         <input type="password" class="form-control" id="cPass" name="cPass">
                     </div>
                     <button type="submit" class="btn btn-primary">Signup</button>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>