<?php

namespace Tests\Unit;

use Tests\UnitCase;

class HelperTest extends UnitCase
{
    /**
     * A basic sku example.
     *
     * @return void
     */
    public function test_should_generate_sku_from_name() {
        $this->assertTrue( createSku('Sku Helper') == 'sku-helper' );
    }

    public function test_csv_uploader(){
        $this->assertTrue(csvReaderHelper('csv/test.csv')[0]['id'] == 'test_id_1');
    }
}
