<?= $this->extend('auth/temp/index'); ?>

<?= $this->section('konten'); ?>
<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-xl-5">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
              </div>

              <?php if (!empty(session()->getFlashdata('error'))) : ?>
              <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata('error'); ?>
              </div>
              <?php endif; ?>

              <form class="user" method="post" action="<?= base_url(); ?>/user/proses_login">
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" name="email" aria-describedby="emailHelp"
                    placeholder="Email..." required autofocus>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-user" name="password" placeholder="Password"
                    required>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Login
                </button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="<?= base_url('/register'); ?>">Create an Account!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<?= $this->endSection(); ?>