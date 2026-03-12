<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tartozás kérelem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
 <body style="background: linear-gradient(135deg,
    #2b1055 0%,
    #4b1f7a 35%,
    #6a2bbd 70%,
    #a855f7 100%)">
    <div class="container">
      <div class="card my-10">
        <div class="card-body">

          <h1 class="h3 mb-2">Tartozási kérelem</h1>
            @foreach ($result as $row)
                <h5 class="text-teal-700">Tisztelt {{ $row->partner_nev }}!</h5>
            @endforeach
          <hr>
          <div class="space-y-3">
            <p class="text-gray-700">Click the "Render" button at the top of the page every time you want to rebuild the email.</p>
            <p class="text-gray-700">
              We hope you enjoy using Bootstrap Email. This is our Online Editor that allows you to edit emails
              and have them render directly in the browser. The outputted HTML will be in the "HTML" tab in the top
              and that is the HTML you want to use to send emails. All the styles and responsive CSS are self contained in the
              HTML that is generated making is very portable needing no external CSS files.
            </p>
            <p class="text-gray-700">
              You can use the "Test" button to email yourself the outputted code to test in your inbox and email client.
            </p>
            <p class="text-gray-700">
              Check out the <a href="https://bootstrapemail.com/docs/introduction" target="_blank">Documentation</a> for syntax and usage of writing emails with Bootstrap Email.
            </p>
          </div>
          <hr>
          <a class="btn btn-primary" href="https://app.bootstrapemail.com/templates" target="_blank">Get More Email Templates</a>
        </div>
      </div>
    </div>
  </body>
</html>

