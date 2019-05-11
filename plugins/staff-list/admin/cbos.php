<?php
//==DROPDOWNS================================================
function abcfsl_cbo_yn() {
    return array('Y' => abcfsl_txta(5),
                'N'  => abcfsl_txta(6)
        );
}

function abcfsl_cbo_show_field() {
    return array('L' => abcfsl_txta(68),
	'S' => abcfsl_txta(69),
        'Y' => abcfsl_txta(70)
        );
}

function abcfsl_cbo_hide_delete() {
    return array('N' => abcfsl_txta(6),
        'H' => abcfsl_txta(76),
        'D'  => abcfsl_txta(321)
        );
}

//-------------------------------------------------------
function abcfsl_cbo_field_cntr_spg() {
    return array('T' => abcfsl_txta(285),
        'M' => abcfsl_txta(145),
        'B' => abcfsl_txta(315)
        );
}

function abcfsl_cbo_tag_type() {
    return array(
        'div' => 'DIV',
        'p' => 'P',
        'h1' => 'H1',
        'h2'  => 'H2',
        'h3'  => 'H3',
        'h4'  => 'H4',
        'h5'  => 'H5',
        'h6'  => 'H6',
        'span'  => 'span'
        );
}

function abcfsl_cbo_tag_type_spg() {
    $first = array( '' => ' - - - ');
    $second = abcfsl_cbo_tag_type();
    return $first + $second;
}

function abcfsl_cbo_txt_margin_top() {
    return array('D' => abcfsl_txta(7),
        '2' => '2 px',
        '3' => '3 px',
        '4' => '4 px',
        '5' => '5 px',
        '7' => '7 px',
        '10' => '10 px',
        '15' => '15 px',
        '20' => '20 px',
        '25' => '25 px',
        '30' => '30 px',
        '40' => '40 px',
        '50' => '50 px',
        'Pc1' => '1%',
        'Pc2' => '2%',
        'Pc3' => '3%',
        'Pc4' => '4%',
        'Pc5' => '5%',
        'Pc6' => '6%',
        'Pc7' => '7%',
        'Pc8' => '8%',
        'Pc9' => '9%',
        'Pc10' => '10%',
        'C' => abcfsl_txta(20)
    );
}

function abcfsl_cbo_txt_margin_top_spg() {
    $first = array( '' => ' - - - ');
    $second = abcfsl_cbo_txt_margin_top();
    return $first + $second;
}

function abcfsl_cbo_font_size_spg() {

    $first = array( '' => ' - - - ');
    $second = abcfsl_cbo_font_size();
    return $first + $second;
}

//Sort keyword or manual
function abcfsl_cbo_sort_type() {
    return array('M'  => abcfsl_txta(60),
        'T'  => abcfsl_txta(61)
        );
}
//-----------------------------------------------

//Staff page layouts: list, grid...
function abcfsl_cbo_staff_pg_layout() {
    return array('0'  => '- - -',
        '1'  => abcfsl_txta(215)
        );
}

//Single page layouts: Two columns, ...
function abcfsl_cbo_staff_single_pg_layout() {
    return array('0'  => abcfsl_txta(6),
        '1'  => abcfsl_txta(5)
        );
}

//Responsive list layout. Width of the left/right sections
function abcfsl_cbo_list_columns() {
    return array('1' => '1 - 11',
        '2'  => '2 - 10',
        '3'  => '3 - 9',
        '4'  => '4 - 8',
        '5'  => '5 - 7',
        '6'  => '6 - 6',
        '7'  => '7 - 5',
        '8'  => '8 - 4',
        '9'  => '9 - 3',
        '10'  => '10 - 2',
        '11'  => '11 - 1',
        '12'  => '12 - 0');
}

function abcfsl_cbo_txt_cntr() {
    return array(
        'div' => 'DIV',
        'p' => 'P',
        'h1' => 'H1',
        'h2'  => 'H2',
        'h3'  => 'H3',
        'h4'  => 'H4',
        'h5'  => 'H5',
        'h6'  => 'H6',
        'span'  => 'span'
        );
}

//FOR Add new field   'SC'  => abcfsl_txta(3), 'HL'  => abcfsl_txta(324)
function abcfsl_cbo_field_type() {
    return array('N'  => '- - -',
        'T'  => abcfsl_txta(38),
        'PT'  => abcfsl_txta(86),
        'CE'  => abcfsl_txta(73),
        'MP'  => abcfsl_txta(313),
        'EM'  => abcfsl_txta(290),
        'H'  => abcfsl_txta(82),
        'TH'  => abcfsl_txta(256),
        'LT'  => abcfsl_txta(206),
        'HL'  => abcfsl_txta(324)
    );
}

//FOR Field number and datatype. Includes depreciated 'SH' (74)
function abcfsl_cbo_field_type_all() {
    return array('N'  => '- - -',
        'T'  => abcfsl_txta(38),
        'PT'  => abcfsl_txta(86),
        'CE'  => abcfsl_txta(73),
        'MP'  => abcfsl_txta(313),
        'EM'  => abcfsl_txta(290),
        'H'  => abcfsl_txta(82),
        'TH'  => abcfsl_txta(256),
        'SH'  => abcfsl_txta(74),
        'LT'  => abcfsl_txta(206),
        'SC'  => abcfsl_txta(3),
        'HL'  => abcfsl_txta(324),
        'STXT'  => abcfsl_txta(182),
        'CBO'  => abcfsl_txta(234),
        'LBLCBO'  => abcfsl_txta(274)  
        );
}

function abcfsl_cbo_123() {
    return array('0'  => abcfsl_txta(76),
        '1'  => '1',
        '2'  => '2',
        '3'  => '3',
        '4'  => '4');
}

//-------------------------
function abcfsl_cbo_margin_top_field() {
    return array('D' => abcfsl_txta(7),
        '5' => '5 px',
        '7' => '7 px',
        '10' => '10 px',
        '15' => '15 px',
        '20' => '20 px',
        '25' => '25 px',
        '30' => '30 px',
        '40' => '40 px',
        '50' => '50 px',
        'C' => abcfsl_txta(20)
    );
}

// function abcfsl_cbo_font_size() {
//     return array('D' => abcfsl_txta(7),
//         '32_7' => '32 px. Bold.',
//         '28_7' => '28 px. Bold.',
//         '24_7' => '24 px. Bold.',
//         '24_7' => '24 px. Bold.',
//         '20_7' => '20 px. Bold.',
//         '18_7' => '18 px. Bold.',
//         '16_7' => '16 px. Bold.',
//         '14_7' => '14 px. Bold.',
//         '13_7' => '13 px. Bold.',
//         '12_7' => '12 px. Bold.',
//         '32_6' => '32 px. Semi-Bold.',
//         '28_6' => '28 px. Semi-Bold.',
//         '24_6' => '24 px. Semi-Bold.',
//         '24_6' => '24 px. Semi-Bold.',
//         '20_6' => '20 px. Semi-Bold.',
//         '18_6' => '18 px. Semi-Bold.',
//         '16_6' => '16 px. Semi-Bold.',
//         '14_6' => '14 px. Semi-Bold.',
//         '13_6' => '13 px. Semi-Bold.',
//         '12_6' => '12 px. Semi-Bold.',
//         '32' => '32 px. Normal.',
//         '28' => '28 px. Normal.',
//         '24' => '24 px. Normal.',
//         '24' => '24 px. Normal.',
//         '20' => '20 px. Normal.',
//         '18' => '18 px. Normal.',
//         '16' => '16 px. Normal.',
//         '14' => '14 px. Normal.',
//         '13' => '13 px. Normal.',
//         '12' => '12 px. Normal.',
//         'C' => abcfsl_txta(20)
//     );
// }

function abcfsl_cbo_font_size() {
    return array('D' => abcfsl_txta(7),        
        '12' => '12 px. Normal.',
        '13' => '13 px. Normal.', 
        '14' => '14 px. Normal.',
        '16' => '16 px. Normal.',
        '18' => '18 px. Normal.',
        '20' => '20 px. Normal.',
        '24' => '24 px. Normal.',
        '28' => '28 px. Normal.',
        '32' => '32 px. Normal.',
        '36' => '36 px. Normal.',
        '12_6' => '12 px. Semi-Bold.',
        '13_6' => '13 px. Semi-Bold.',
        '14_6' => '14 px. Semi-Bold.',
        '16_6' => '16 px. Semi-Bold.',
        '18_6' => '18 px. Semi-Bold.',
        '20_6' => '20 px. Semi-Bold.',
        '24_6' => '24 px. Semi-Bold.',
        '28_6' => '28 px. Semi-Bold.',
        '32_6' => '32 px. Semi-Bold.',
        '36_6' => '36 px. Semi-Bold.',
        '12_7' => '12 px. Bold.',
        '13_7' => '13 px. Bold.',
        '14_7' => '14 px. Bold.',
        '16_7' => '16 px. Bold.',
        '18_7' => '18 px. Bold.',
        '20_7' => '20 px. Bold.',
        '24_7' => '24 px. Bold.',
        '24_7' => '24 px. Bold.',        
        '32_7' => '32 px. Bold.',
        '36_7' => '36 px. Bold.',
        'C' => abcfsl_txta(20)
    );
}

function abcfsl_cbo_img_border() {
    return array('D' => abcfsl_txta(7),
        '1' => 'Gray 1',
        '2' => 'Gray 2',
        '3' => 'Gray 3',
        '4' => 'Gray 4',
        '5' => 'Black',
        'C' => abcfsl_txta(20)
        );
}

function abcfsl_cbo_margin_top_social() {
    return array('N' => ' - - - ',
        '5' => '5 px',
        '10' => '10 px',
        '15' => '15 px',
        '20' => '20 px',
        '25' => '25 px',
        '30' => '30 px',
        '40' => '40 px',
        '50' => '50 px',
        'Pc1' => '1%',
        'Pc2' => '2%',
        'Pc3' => '3%',
        'Pc4' => '4%',
        'Pc5' => '5%',
        'Pc6' => '6%',
        'Pc7' => '7%',
        'Pc8' => '8%',
        'Pc9' => '9%',
        'Pc10' => '10%',
        'C' => abcfsl_txta(79)
    );
}