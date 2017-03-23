<div class="profile-resume">

    <section class="mbl">

        <table cellspacing="0"><tbody>

            <tr>
                <td class="label">ยอดจอง</td>
                <td class="data"><?=(!empty($this->item['booking'])?$this->item['booking']:'-')?></td>
            </tr>

            <tr>
                <td class="label">คงเหลือ</td>
                <td class="data"><?=(!empty($this->item['balance'])?$this->item['balance']:'-')?></td>
            </tr>

            <tr>
                <td class="label">รวม</td>
                <td class="data"><?=(!empty($this->item['subtotal'])?$this->item['subtotal']:'-')?></td>
            </tr>

            <tr>
                <td class="label"><span class="fcr">ต้องสั่งเพิ่ม</span></td>
                <td class="data"><?=(!empty($this->item['amount_reservation'])?$this->item['amount_reservation']:'-')?></td>
            </tr>

           <!--  <tr>
                <td class="label">จำหน่าย</td>
                <td class="data"><?=(!empty($this->item['soldtotal'])?$this->item['soldtotal']:'-')?></td>
            </tr>

            <tr>
                <td class="label">รวมทั้งหมด</td>
                <td class="data"><?=(!empty($this->item['total'])?$this->item['total']:'-')?></td>
            </tr> -->

        </tbody></table>

    </section>
</div>