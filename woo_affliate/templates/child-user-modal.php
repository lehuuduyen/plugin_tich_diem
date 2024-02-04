<?php
foreach ($usersDisplay as $keyUserModal => $user) {
  $childUser = array();
  $userChild = $wpdb->get_results('SELECT * FROM ' . $tableShareLink . ' INNER JOIN '.$tableUser.' ON '.$tableUser.'.ID=' . $tableShareLink . '.user_id  where status = 2 AND user_parent = ' . $user['ID'], ARRAY_A);

  if ($userChild) {
    foreach ($userChild as $child) {
      array_push($childUser, $child);
    }
  }


?>
  <div class="modal d-none modal-lower-level-<?php echo $user['ID']; ?>">
    <div class="modal-wrapper">
      <p onclick="closeLowerModal(<?php echo $user['ID']; ?>)" class="close">✕</p>
      <div class="modal-header">
        <p>Cấp dưới</p>
      </div>
      <div class="modal-content">
        <table class="wp-list-table widefat fixed striped table-view-list users">
          <thead>
            <tr>
              <th>Tên cấp dưới</th>
              <th>Tổng hoa hồng <span class="d-none"><br /> sum (commision status 1 (<b style="color: red;">USER CON</b>))</span></th>
              <th>Tổng doanh thu <span class="d-none"><br /> sum (total_order status 1 (<b style="color: red;">USER CON</b>))</span></th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($childUser) === 0) { ?>
              <tr>
                <td>Không có cấp dưới</td>
              </tr>
              <?php } else {
              foreach ($childUser as $child) {
                $childCommissions = $wpdb->get_results('SELECT sum(commission) as childCommissions FROM ' . $tableUserCommission . ' WHERE user_id = ' . $child['ID'] . ' AND status = ' . $status['PURCHASE'] . ' ORDER BY id ASC');
                $childRevenue = $wpdb->get_results('SELECT sum(total_order) as childRevenue FROM ' . $tableUserCommission . ' WHERE user_id = ' . $child['ID'] . ' AND status = ' . $status['PURCHASE'] . ' ORDER BY id ASC');
              ?>
                <tr>
                  <td><?php echo $child['user_nicename'] . ' - ' . $child['user_login']; ?></td>
                  <td><?php echo $childCommissions[0]->childCommissions; ?></td>
                  <td><?php echo $childRevenue[0]->childRevenue; ?></td>
                </tr>
            <?php }
            } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php } ?>