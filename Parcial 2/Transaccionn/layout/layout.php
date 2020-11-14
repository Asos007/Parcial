<?php

class Layout
{

   
    public $directory;
    public $onDirectory;

    
    public function __construct($onDirectory)
    {

        $this->onDirectory = $onDirectory;
        $this->directory = ($this->onDirectory) ? "../" : "";

    }

    
    public function printHeader()
    {

        $header = <<<EOF

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Registro de Estudiantes</title>

  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
  <!-- Bulma CSS -->
  <link href="{$this->directory}vendor/bulma/css/bulma.css" rel="stylesheet">
  
  <style>
  body{
      font-family: 'Roboto';
      font-size:1.2em;
  }

  .table th, .table td{
    vertical-align: middle;
  }

</style>

</head>



<body>

  <!-- Navigation -->
  <nav class="navbar is-black" role="navigation" aria-label="main navigation">
  <div class="container">
    <div class="navbar-brand">
      <a class="navbar-item" href="https://bulma.io">
        <h1 class="is-size-4">Transcash</h1>
      </a>

      <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>
  </div>
  
</nav>
EOF;

        echo $header;
    }

    
    public function printFooter()
    {

        $footer = <<<EOF
</body>

</html>

EOF;

        echo $footer;
    }

}