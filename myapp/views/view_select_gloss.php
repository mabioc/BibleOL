<?php
define('BUTTONS_PER_LINE', 8);

// This is how you export $editing as a global variable
global $editing_glob;
$editing_glob = $editing;

function button_type(int $index, int $button_index=null) {
    return $index===$button_index ? "btn-info" : "btn-outline-dark";
}


function build_url2(array $get_parms)
{
    global $editing_glob;
    
    switch ($editing_glob) {
        case 'url':
            return site_url(build_get('urls/edit_url',$get_parms));

        case 'lexicon':
            return site_url(build_get('translate/edit_lex',$get_parms) . '#targetlang');
    }
}


function show_buttons(string $head, 
                      array $get_parms,
                      array $button_array,
                      int $number_glosses,
                      string $style,
                      int $gloss_count) {
    $CI =& get_instance();

    $right_to_left = in_array($get_parms['src_lang'], array('heb','aram'));

    $number_freq_buttons = ceil($number_glosses/$gloss_count);
?>
    <div class="card mb-3">
        <h5 class="card-header bg-info text-light"><?= $head ?></h5>
        <div class="card-body">
            <h2><?= $CI->lang->line('by_frequency') ?></h2>
            <div style="display:flex;flex-flow:row wrap">
                <?php for ($ix=0; $ix<$number_freq_buttons; ++$ix): ?>
                    <div style="flex-basis:7.5em">
                        <a style="width:100%" href="<?= build_url2(array('buttonix'=>-$ix-1) + $get_parms) ?>"
                           class="btn <?= button_type(-$ix-1, $get_parms['buttonix']) ?>"><?= sprintf("%d-%d",$gloss_count*$ix+1,min($number_glosses,$gloss_count*($ix+1))) ?></a>
                    </div>
                <?php endfor; ?>
            </div>
            <p>&nbsp;</p>
            <h2><?= $CI->lang->line('alphabetically') ?></h2>
            <div class="<?= $style ?>" style="display:flex;
                        <?= $right_to_left ? 'flex-flow:row-reverse wrap'
                                           : 'flex-flow:row wrap'?>">
                <?php for ($ix=0; $ix<count($button_array); ++$ix): ?>
                    <div style="flex-basis:7.5em">
                        <a style="width:100%" href="<?= build_url2(array('buttonix'=>$ix) + $get_parms) ?>"
                           class="btn <?= button_type($ix, $get_parms['buttonix']) ?>">
                            <?= $button_array[$ix][0] ?>
                        </a>
                    </div>
                <?php endfor; ?>
            </div>
        </div><!--card-body-->
    </div><!--card-->
<?php
}
?>


<?php switch ($get_parms['src_lang']):
case 'all-with-greek':
case 'all-no-greek': ?>
<?php show_buttons($this->lang->line('hebrew_glosses'),  array('src_lang'=>'heb')   + $get_parms, $heb_buttons,   $heb_glosses, 'heb-default', $gloss_count); ?>
<?php show_buttons($this->lang->line('aramaic_glosses'), array('src_lang'=>'aram')  + $get_parms, $aram_buttons,  $aram_glosses, 'heb-default', $gloss_count); ?>

<?php if ($get_parms['src_lang']=='all-with-greek'): ?>
    <?php show_buttons($this->lang->line('greek_glosses'), array('src_lang'=>'greek') + $get_parms, $greek_buttons, $greek_glosses, 'greek-default',$gloss_count); ?>
<?php else: ?>

    <div class="card mb-3">
        <h5 class="card-header bg-info text-light"><?= $this->lang->line('greek_glosses') ?></h5>
        <div class="card-body">
            <?= $this->lang->line('no_greek') ?>
        </div><!--card-body-->
    </div><!--card-->

<?php endif; ?>
<?php break; ?>

<?php case 'heb': ?>
<?php show_buttons($this->lang->line('hebrew_glosses'),
                   array('src_lang'=>'heb') + $get_parms, 
                   $buttons,
                   $num_glosses,
                   'heb-default',
                   $gloss_count); ?>
<?php break; ?>

<?php case 'aram': ?>
<?php show_buttons($this->lang->line('aramaic_glosses'),
                   array('src_lang'=>'aram') + $get_parms,
                   $buttons,
                   $num_glosses,
                   'heb-default',
                   $gloss_count); ?>
<?php break; ?>

<?php case 'greek': ?>
<?php show_buttons($this->lang->line('greek_glosses'),
                   array('src_lang'=>'greek') + $get_parms,
                   $buttons,
                   $num_glosses,
                   'greek-default',
                   $gloss_count); ?>
<?php break; ?>

<?php endswitch; ?>
