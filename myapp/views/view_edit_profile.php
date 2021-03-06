    <?php $valerr = validation_errors();
      if (!empty($valerr))
          echo "<div class=\"alert alert-danger\">$valerr</div>\n";
    ?>

    <script>
        $(function() {
            function set_full_name() {
                var first_name = $('[name=first_name]').val();
                var last_name = $('[name=last_name]').val();
                
                if ($('[name=family_name_first]:checked').val()=='yes')
                    $('#fullname').html('（' + last_name + first_name + '）');
                else
                    $('#fullname').html('(' + first_name + ' ' + last_name + ')');
            }

            set_full_name();
                    
            $('[name=family_name_first]').on('change', set_full_name);
            $('[name=first_name]').on('input', set_full_name);
            $('[name=last_name]').on('input', set_full_name);
        });
                
    </script>

    <?= form_open("users/profile") ?>
      <table class="form">
        <tr>
          <td><?= $this->lang->line('user_name') ?></td>
          <td class="norb"><?= $user_info->username ?></td>
          <td class="nolb"><?= $this->lang->line('cannot_change') ?></td>
        </tr>
        <tr>
          <td><?= $this->lang->line('first_name') ?></td>
          <td class="norb"><input type="text" name="first_name" value="<?= set_value('first_name',$user_info->first_name) ?>"></td>
          <td class="nolb"><?= $this->lang->line('field_required') ?></td>
        </tr>
        <tr>
          <td><?= $this->lang->line('last_name') ?></td>
          <td class="norb"><input type="text" name="last_name" value="<?= set_value('last_name',$user_info->last_name) ?>"></td>
          <td class="nolb"><?= $this->lang->line('field_required') ?></td>
        </tr>
        <tr>
          <td><?= $this->lang->line('chinese_name_order') ?></td>
          <td class="norb">
            <input class="narrow" type="radio" name="family_name_first" value="yes" <?= set_radio('family_name_first', 'yes', !!$user_info->family_name_first) ?>><?= $this->lang->line('yes') ?>
            <input class="narrow" type="radio" name="family_name_first" value="no" <?= set_radio('family_name_first', 'no', !$user_info->family_name_first) ?>><?= $this->lang->line('no') ?>
          </td>
          <td id="fullname" class="nolb"></td>
        </tr>
        <tr>
          <td><?= $this->lang->line('email') ?></td>
          <td class="norb"><input type="text" name="email" value="<?= set_value('email',$user_info->email) ?>"></td>
          <td class="nolb"></td>
        </tr>
        <tr>
          <td><?= $this->lang->line('preferred_language') ?></td>
          <td class="norb">
            <select name="preflang">
              <option value="none" <?= set_select('preflang', 'none', $user_info->preflang=='none') ?>><?= $this->lang->line('no_language') ?></option>

              <?php foreach ($avail_if_trans as $ift): ?>
                <option value="<?= $ift->abb ?>" <?= set_select('preflang', $ift->abb, $user_info->preflang==$ift->abb) ?>><?= $this->lang->line($ift->internal) ?></option>
              <?php endforeach; ?>

            </select>
          </td>
          <td class="nolb"></td>
        </tr>
        <?php if (!empty($this->config->item('variants'))): ?>
          <tr>
            <td><?= $this->lang->line('preferred_variant') ?></td>
            <td class="norb">
              <select name="prefvariant">
               <option value="none" <?= set_select('prefvariant', 'none', $user_info->prefvariant=='none') ?>><?= $this->lang->line('no_variant_option') ?></option>
               <option value="main" <?= set_select('prefvariant', 'main', $user_info->prefvariant=='main') ?>><?= $this->lang->line('main_variant') ?></option>

               <?php foreach ($this->config->item('variants') as $var): ?>
                 <option value="<?= $var ?>" <?= set_select('prefvariant', $var, $user_info->prefvariant==$var) ?>><?= $var ?></option>
               <?php endforeach; ?>

              </select>
            </td>
            <td class="nolb"></td>
          </tr>
        <?php endif; ?>
        <tr>
          <td><?= $this->lang->line('new_password') ?></td>
          <td class="norb"><input type="password" name="password1" value=""></td>
          <td class="nolb"><?= $this->lang->line('leave_blank_pw') ?></td>
        </tr>
        <tr>
          <td><?= $this->lang->line('repeat_new_password') ?></td>
          <td class="norb"><input type="password" name="password2" value=""></td>
          <td class="nolb"><?= $this->lang->line('leave_blank_pw') ?></td>
        </tr>
      </table>
      <p style="height:2px">&nbsp;</p>
      <p><input class="btn btn-primary" type="submit" name="submit" value="<?= $this->lang->line('OK_button') ?>">
            <a class="btn btn-outline-dark" href="<?= site_url('/') ?>"><?= $this->lang->line('cancel_button') ?></a></p>
    </form>

