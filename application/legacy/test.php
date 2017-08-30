<?php
$znumber = "Z11111111";
$code = "SFA020";
$note = "Not a Note";
$accepted = "500";
$ranking = "2";
include 'header.php';
?>
<a href="#" tabindex="0" data-placement="auto" data-toggle="popover" data-trigger="click focus" data-html="1" data-content=
      '<form class="form-horizontal">
        <div class="form-group">
          <label for="note" class="col-sm-2">Note</label>
          <div class="col-sm-10">
            <input name="note" app_id="<?=$znumber?>:<?=$code?>" class="form-control" placeholder="Notes" maxlength="50"
              <?= !empty($note) ? "value=\"".$note."\"" : ""; ?>
            "/>
          </div>
        </div>
        <div class="form-group">
          <label for="award" class="col-sm-2">Award</label>
          <div class="col-sm-10">
            <div class="input-group">
              <input name="award" app_id="<?=$znumber?>:<?=$code?>" class="form-control" placeholder="Award Amount"
                <?= !empty($accepted) ? "value=\"".$accepted."\"" : ""; ?>
              "/>
              <span class="input-group-addon" data-toggle="tooltip" data-html="1" data-placement="auto" title="Undecided: Do Nothing. <br />Rejected: Submit 0. <br />Accepted: Submit Award Amount (No $ or Decimal) ">?</span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="rank" class="col-sm-2">Rank</label>
          <div class="col-sm-10">
            <input name="rank" app_id="<?=$znumber?>:<?=$code?>" class="form-control" placeholder="Ranking"
              <?= isset($ranking) ? "value=\"".$ranking."\"" : ""; ?>
            "/>
          </div>
        </div>
        <button call="decision" class="btn btn-primary center-block" type="button">Decide!</button>
      </form>'>
<?= is_null($accepted) ? "Make" : "Change"; ?>
Decision</a>

<?php 
include 'footer.php';
?>
<script>
$(function () {
          $('body').popover({
              selector: '[data-toggle="popover"]'
          });

          $('body').tooltip({
            selector: 'a[rel="tooltip"], [data-toggle="tooltip"]'
          });
      });
      $('html').on('click', function(e) {
        if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover.in')) {
          $('[data-original-title]').popover('hide');
        }
      });
</script>