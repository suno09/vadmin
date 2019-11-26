<nav class="main-header navbar navbar-expand navbar-white navbar-light ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Add Action -->
      <li class="nav-item dropdown">
        <a class="nav-link" href="#">
        <i class="fas fa-plus-circle"></i>
        Nouveau Produit
        </a>  
      </li>
      <!-- Logout Menu -->
      <li class="nav-item" data-toggle="modal" data-target="#modal-default">
        <a class="nav-link" href="#">
        <i class="fas fa-sign-out-alt"></i>
            Déconnexion
        </a>
      </li>
    </ul>
</nav>

<!-- logout modal -->
<div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Déconnexion</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Non">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Voulez vous déconnecter&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
              <button type="button" class="btn btn-primary" onclick="logout()">Oui</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<script>
function logout(){ 
    var a = document.createElement("a");
    a.href = "index.php?logout";
    var clickEvent = new MouseEvent("click", {
        "view": window,
        "bubbles": true,
        "cancelable": false
    });
    a.dispatchEvent(clickEvent);}
</script>