<?php $title = 'Homepage'; ?>

<?php ob_start(); ?>

<body>
  <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic">The best event of your region we've made</h1>
      <p class="lead my-3">
        All the biggest event in your region can be found here</p>
    </div>
  </div>
  <div>
    <h1>Next event</h1>
  </div>
  <div class="row mb-1">
    <div class="col-md-12">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">

        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary">Name of category</strong>
          <div class="mb-2 text-muted">Name Event</div>
          <div class="mb-2 text-muted">Date Event</div>
          <div class="mb-2 text-muted">Place</div>
          <a href="#" class="stretched-link">Go page of this event</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary">Name of category</strong>
          <div class="mb-2 text-muted">Name Event</div>
          <div class="mb-2 text-muted">Date Event</div>
          <div class="mb-2 text-muted">Place</div>
          <a href="#" class="stretched-link">Go page of this event</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary">Name of category</strong>
          <div class="mb-2 text-muted">Name Event</div>
          <div class="mb-2 text-muted">Date Event</div>
          <div class="mb-2 text-muted">Place</div>
          <a href="#" class="stretched-link">Go page of this event</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary">Name of category</strong>
          <div class="mb-2 text-muted">Name Event</div>
          <div class="mb-2 text-muted">Date Event</div>
          <div class="mb-2 text-muted">Place</div>
          <a href="#" class="stretched-link">Go page of this event</a>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary">Name of category</strong>
          <div class="mb-2 text-muted">Name Event</div>
          <div class="mb-2 text-muted">Date Event</div>
          <div class="mb-2 text-muted">Place</div>
          <a href="#" class="stretched-link">Go page of this event</a>
        </div>
      </div>
    </div>
  </div>
  </div>

  <?php $content = ob_get_clean(); ?>
  <?php require('template.php'); ?>
