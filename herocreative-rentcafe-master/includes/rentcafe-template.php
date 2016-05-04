<?php if ($property_data && !property_exists($property_data[0], 'Error' ) ) : ?>

<div class="postbox herocreative-rentcafe-tabs section group">
  <ul class="col span_1_of_2">

    <?php foreach ($property_data as $data) : ?>

    <li>
      <a href="#tabs-<?php echo $data->FloorplanId; ?>">
        <?php echo $data->FloorplanName; ?>
      </a>
    </li>

    <?php endforeach; ?>

  </ul>

  <?php foreach ($property_data as $data) : ?>

  <div id="tabs-<?php echo $data->FloorplanId; ?>" class="col span_2_of_2">
    <h2><?php echo $data->FloorplanName; ?> <small>(<?php echo $data->AvailableUnitsCount ?> Available)</small></h2>
    <table>
      <tbody>
        <tr>
          <th data-field="beds">Beds</th>
          <td> <?php echo $data->Beds; ?> </td>
        </tr>
        <tr>
          <th data-field="bath">Bath</th>
          <td> <?php echo $data->Baths; ?> </td>
        </tr>

        <?php
          $max_and_min_sqrt_are_equal = $data->MaximumSQFT == $data->MinimumSQFT;
          if( $data->MinimumSQFT > 1 ) : ?>

        <tr>
          <th data-field="sqrft">SQ.FT.</th>
          <td>
            <?php echo $data->MinimumSQFT; ?>
            <?php echo ($max_and_min_sqrt_are_equal) ? null : '- ' . $data->MaximumSQFT; ?>
          </td>
        </tr>

        <?php endif; ?>


        <?php
          $valid_rents = $data->MinimumRent > 0 && $data->MaximumRent > 0;
          if( $valid_rents ) : ?>

        <tr>
          <th data-field="rent">Rent</th>
          <td> $ <?php echo $data->MinimumRent; ?> - $<?php echo $data->MaximumRent; ?> </td>
        </tr>

        <?php endif; ?>

      </tbody>
    </table>

    <div class="floorplan-img">
      <img src="<?php echo $data->FloorplanImageURL; ?>" alt="<?php echo $data->FloorplanName; ?>">
    </div>
  </div>

  <?php endforeach; ?>

</div>
<!-- .postbox -->

<?php endif; ?>
