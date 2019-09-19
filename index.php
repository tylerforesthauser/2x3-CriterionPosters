<?php
  require_once __DIR__ . '/inc/hQuery/hquery.php';
  use duzun\hQuery;
  $doc = hQuery::fromUrl('https://www.criterion.com/shop/browse/list?sort=spine_number', ['Accept' => 'text/html,application/xhtml+xml;q=0.9,*/*;q=0.8']);
  $rows = $doc->find(' table > tbody > tr');

  // EDIT THIS!
  $CLOUDINARY_USERNAME = "";

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    <title>Criterion Collection - Custom 2:3 Posters w/ Spine #</title>
  </head>
<body>
  <div class="container">
    <div class="row">
      <div class="col my-5">
        <table id="criterion" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="spine">Spine #</th>
              <th>Title (Year)</th>
              <th>Poster Links</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($rows as $pos => $el) {
              $spine = $el->find('td.g-spine');
              $spine_number = trim(preg_replace('/\t+/', '', $spine->text() ));
              $title = $el->find('td.g-title');
              $year = trim(preg_replace('/\t+/', '', $el->find('td.g-year')->text() ));
              $img = $el->find('td.g-img > img');
              $img_lg_url = preg_replace('/(?:.(?!_))+$/', '_large.jpg', $img->attr('src'));
              if ( is_numeric($spine_number) ) {
                $new_img = 'https://res.cloudinary.com/'.$CLOUDINARY_USERNAME.'/image/fetch/c_lpad,h_1500,w_1000,b_auto/e_auto_brightness,l_text:Montserrat_60:Spine%20%23' . $spine->text() . ',g_south_east,y_30,x_30/' . $img_lg_url;
                $new_img_white_text = 'https://res.cloudinary.com/'.$CLOUDINARY_USERNAME.'/image/fetch/c_lpad,h_1500,w_1000,b_auto/e_auto_brightness,l_text:Montserrat_60:Spine%20%23' . $spine->text() . ',g_south_east,y_30,x_30,co_white/' . $img_lg_url;
                echo '<tr>' . '<td class="text-center">' . $spine_number . '</td><td>' . $title . '(' . $year . ')' . '</td><td class="text-center"><a href="' . $new_img . '" class="badge badge-light">Link</a> <a href="'. $new_img_white_text .'" class="badge badge-dark">Link</a></td></tr>';
              } else {
                $new_img = 'https://res.cloudinary.com/'.$CLOUDINARY_USERNAME.'/image/fetch/c_lpad,h_1500,w_1000,b_auto/' . $img_lg_url;
                echo '<tr>' . '<td>&nbsp;</td><td>' . $title . '(' . $year . ')' . '</td><td class="text-center"><a href="' . $new_img . '" class="badge badge-light">Link</a></td></tr>';
              }
            } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/absolute.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#criterion').DataTable( {
        columnDefs: [
          { targets: 0, type: "num" }
        ]
      } );
    } );
  </script>
</body>
</html>