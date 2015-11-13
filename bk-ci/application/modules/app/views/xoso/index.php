<?php
header("Content-type: text/xml; charset=utf-8");

$mang = array(
    array('a0', 'Giải Đặc Biệt'),
    array('a1', 'Giải Nhất'),
    array('a2', 'Giải Nhì'),
    array('a3', 'Giải Ba'),
    array('a4', 'Giải Tư'),
    array('a5', 'Giải Năm'),
    array('a6', 'Giải Sáu'),
    array('a7', 'Giải Bảy'),
    array('a8', 'Giải Tám')
);

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
if ($items):
    ?>
    <chanel>
        <?php
        foreach ($items as $k => $v):
            ?> 
            <area codeLocal="<?php echo $v[0]->area; ?>" nameLocal="<?php echo $v[0]->area_name; ?>">
            <?php foreach ($v as $kv => $vv): ?>
                <result  idlocal="<?php echo $vv->code; ?>" namelocal="<?php echo $vv->name; ?>">
                    <XoSo data="<?php echo $vv->strday; ?>">
                        <?php foreach ($mang as $km => $vm): ?>
                            <item rankName="<?php echo $km; ?>" value="<?php echo $vv->$vm[0]; ?>" rankNumber="<?php echo $vm[1]; ?>"/>
                        <?php endforeach; ?>
                    </XoSo>
                    <?php
                    $lo = json_decode($vv->extension);
                    ?>
                    <Lo>
                        <?php foreach ($lo as $kl => $vl): ?>
                            <itemLo name="<?php echo $kl; ?>" valueLo="<?php echo str_replace(array('&nbsp;', ' '), '', $vl); ?>"/>
                        <?php endforeach; ?>
                    </Lo>
                </result>
            <?php endforeach; ?>
            </area>
        <?php endforeach; ?>
    </chanel>
<?php endif; ?>
<?php die(); ?>