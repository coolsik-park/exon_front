<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 */
?>
<div class="row">
    <div float="left">
        <a href="#신청하기">신청하기</a>
        <a href="#개설자 정보">개설자 정보</a>
        <a href="#상세 정보">상세 정보</a>
        <a href="#취소 및 환불 안내">취소 및 환불 안내</a>
        <a href="#문의">문의</a></div>
    </div>

    <div class="column-responsive column-80">
        <div class="exhibition view content">
            <h2><a name="신청하기">신청하기</a></h2>
            <table>
                <tr>
                    <td rowspan="8"><?php echo $this->Html->image(DS . $exhibition->image_path . DS . $exhibition->image_name); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?= h($exhibition->title) ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?= h($exhibition->description) ?></td>
                </tr>
                <tr>
                    <th>모집일시</th>
                    <td><?= h($exhibition->apply_sdate) ?>~<?= h($exhibition->apply_edate) ?></td>
                </tr>
                <tr>
                    <th>행사일시</th>
                    <td><?= h($exhibition->sdate) ?>~<?= h($exhibition->edate) ?></td>
                </tr>
                <tr>
                    <th>비용</th>
                    <td></td>
                </tr>
                <tr>
                    <th>행사분야</th>
                    <td><?= h($exhibition->category) ?>|<?= h($exhibition->type) ?></td>
                </tr>
                <tr>
                    <th><?= $this->Number->format($exhibition->require_group) ?></th>
                    <td><?= $this->Html->link(__('참가신청'), ['controller' => 'exhibitionUsers'], ['action' => 'add', $exhibition->id], ['class' => 'side-nav-item']) ?></td>
                </tr>
            </table>


            <h2><a name="개설자 정보">개설자 정보</a></h2>
            <table>
                <tr>
                    <td>이미지</td>
                    <td><?= h($exhibition->name) ?></td>
                </tr>
                <tr>
                    <th>이메일</td>
                    <td><?= h($exhibition->email) ?></td>
                </tr>
                <tr>
                    <th>연락처</td>
                    <td><?= h($exhibition->tel) ?></td>
                </tr>
            </table>


            <h2><a name="상세 정보">상세 정보</a></h2>
            <?= $this->Text->autoParagraph($exhibition->detail_html) ?>


            <h2><a name="취소 및 환불 안내">취소 및 환불 안내</a></h2>
            <div class="column" style="background-color:#aaa;">
                ·행사의 신청, 취소, 변경, 환불은 참여신청 기간 내에만 가능합니다.</br>
                ·신청한 행사의 신청, 취소, 변경, 환불은 신청내역에서 확인할 수 있습니다.</br>
                ·결제 완료된 행사는 환불 시 결제 수단과 환불 시점에 따라 수수료가 부과될 수 있습니다.</br>
                ·신청 마감 이후의 신청 정보 취소, 변경, 환불은 행사 개설자에게 문의 부탁드립니다.</br>
                ·행사 그룹 설정, 정원 초과 여부에 따라 대기자로 선정될 수 있습니다.</br>
                ·EXON은 통신판매 중개자이며, 해당 행사의 개설자가 아닙니다. 행사 내용에 관한 사항은 개설자에게 문의 바랍니다.
            </div>


            <h2><a name="문의">문의</a></h2>
            <table>
                <tr>
                    <th>담당자</td>
                    <td><?= h($exhibition->name) ?></td>
                </tr>
                <tr>
                    <th>이메일</td>
                    <td><?= h($exhibition->email) ?></td>
                </tr>
                <tr>
                    <th>연락처</td>
                    <td><?= h($exhibition->tel) ?></td>
                </tr>
            </table>
            
        </div>
    </div>
</div>
