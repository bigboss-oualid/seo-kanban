
    <!--/ Header -->

    <!-- Modal -->


    <div class="modal-header">
        <input class="mod-card-id" type="hidden" value="<?php echo $card->getId(); ?>">
        <div class="mod-title" id="mod-title--">
            <input type="text" class="mod-card-title form-control" value="<?php echo $card->getTitle(); ?>">
            <p class="modal-input-error-msg err-msg-text hide"></p>
        </div>
        <button type="button" class="close close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body mod-description">
        <div class="mod-description-header my-1">
            <h5 class="mod-h5 d-inline">Description</h5>
        </div>
        <div class="mod-description-content">
            <textarea placeholder="Enter card description.." class="mod-description-textarea mod-textarea form-control" rows="4"><?php echo $card->getDescription(); ?></textarea>
        </div>
        <div class="mod-description-controls hide">
            <button class="btn-mod-description-save btn btn-sm btn-default">Save</button>
            <button class="btn-mod-description-clear btn btn-sm btn-danger">Clear</button>
            <button class="close-mod-description-controls btn btn-sm btn-primary">Close</button>
        </div>
    </div>

    <div class="modal-body mod-checklist">
        <div class="mod-checklist-header">
            <h5 class="mod-h5 mod-checklist-h5">Checklist</h5>
        </div>
        <div class="mod-checklist-items">
            <?php foreach($card->getItems() as $checklistItem): ?>
                <div class="mod-checklist-item d-flex" id="mod-checklist-item--<?php echo $checklistItem->getId(); ?>">
                    <div class="form-check mod-checklist-item-check" id="mod-checklist-item-check--<?php echo $checklistItem->getId(); ?>">
                        <input type="checkbox" class="form-check-input mod-checklist-item-is-completed" id="mod-checklist-item-is-completed--<?php echo $checklistItem->getId(); ?>" value="<?php echo $checklistItem->isCompleted(); ?>" <?php echo ($checklistItem->isCompleted() == 1) ? "checked": ""; ?>>
                        <label class="form-check-label" for="mod-checklist-item-is-completed--<?php echo $checklistItem->getId(); ?>"></label>
                    </div>
                    <div class="mod-checklist-item-details" id="mod-checklist-item-details--<?php echo $checklistItem->getId(); ?>">
                        <span class="mod-checklist-item-text" id="mod-checklist-item-text--<?php echo $checklistItem->getId(); ?>"><?php echo $checklistItem->getText(); ?></span>
                    </div>
                    <div class="mod-checklist-item-controls ml-auto d-flex" id="mod-checklist-item-controls--<?php echo $checklistItem->getId(); ?>">
                        <div class="m-1"><span>
                            <i class="fa fa-edit mod-checklist-item-control mod-checklist-item-edit" id="mod-checklist-item-edit--<?php echo $checklistItem->getId(); ?>"></i>
                        </span></div>
                        <div class="m-1"><span>
                            <i class="fa fa-times red-text mod-checklist-item-control mod-checklist-item-delete" id="mod-checklist-item-delete--<?php echo $checklistItem->getId(); ?>"></i>
                        </span></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mod-checklist-item-add-an mt-3">
            <button class="btn-mod-checklist-item-add-an btn btn-sm btn-info">Add an Item</button>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>

    <!-- Modal -->

