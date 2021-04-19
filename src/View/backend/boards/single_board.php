
<div class="board mb-5" id="board--<?php echo $boardId; ?>">

    <div class="board-name m-3" id="board-name--<?php echo $boardId; ?>">
        <h2 class="text-center mt-5"><?php echo $boardName; ?></h2>
    </div>
        <div class="row">

            <!-- add another column -->
            <div class="list-add-another mx-4">
                <button class="list-add-another-btn btn btn-success mt-0 font-weight-bold">Add New Column</button>
                <div class="list-add hide m-1">
                    <input type="text" class="list-add-input form-control" placeholder="Enter column title...">
                    <p class="input-error-msg err-msg-text hide"></p>
                    <button class="list-add-btn btn btn-info">Add new Column</button>
                    <span class=""><i class="list-add-close fa fa-times-circle"></i></span>
                </div>
            </div>
            <!-- end add another column -->
            <div class="col-12 list-wrapper" id="list-wrapper--<?php echo $boardId; ?>">
                <!-- lists -->
                <div class="lists d-inline-flex m-2" id="lists">
                    <?php foreach ($columns as $column): ?>

                        <!-- column -->
                        <div class="list mx-1 align-self-start" id="list--<?php echo $column->getId(); ?>">

                            <div class="list-header d-flex m-2" id="list-header--<?php echo $column->getId(); ?>">
                                <input type="text" class="list-title" id="list-title--<?php echo $column->getId(); ?>" value="<?php echo $column->getTitle(); ?>">
                                <div class="dropdown p-1">
                            <span class="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bars"></i>
                            </span>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item list-edit" id="list-edit--<?php echo $column->getId(); ?>">Edit</a>
                                        <a class="dropdown-item list-delete" id="list-delete--<?php echo $column->getId(); ?>">Delete</a>
                                    </div>
                                </div>
                            </div>

                            <div class="list-cards" id="list-cards--<?php echo $column->getId(); ?>">

                            <?php foreach ($column->getCards() as $card): ?>
                            <?php if ($card){ ?>

                                <div class="d-flex m-2 _card" id="_card--<?php echo $card->getId(); ?>">
                                    <div class="_card-details flex-grow-1 p-1" id="_card-details--<?php echo  $card->getId(); ?>">
                                        <span class="_card-text" id="_card-text--<?php echo  $card->getId(); ?>"><?php echo  $card->getTitle(); ?></span>
                                    </div>
                                    <div class="dropdown p-1">
                                        <span class="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-edit"></i>
                                        </span>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item edit-card" data-toggle="modal" data-target="#modal" id="edit-card--<?php echo  $card->getId(); ?>">Edit</a>
                                            <a class="dropdown-item delete-card" id="delete-card--<?php echo  $card->getId(); ?>">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <p id="card-title-error--<?php echo  $card->getId(); ?>" class="ml-2 err-msg-text hide"></p>
                            <?php } ?>
                            <?php endforeach; ?>

                            </div>

                            <p class="ml-2 title-error-msg--<?php echo $column->getId(); ?> err-msg-text hide"></p>
                            <div class="card-add-another" id="card-add-another--<?php echo $column->getId(); ?>">
                                <button class="btn-card-add-another btn btn-primary btn-sm" id="btn-card-add-another--<?php echo $column->getId(); ?>">Add New Card</button>
                            </div>

                        </div>
                        <!-- end column -->

                    <?php endforeach; ?>

                </div>
                <!-- end lists -->

            </div>
        </div>


    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"></div>
        </div>
    </div>

</div>

<!-- Custom JavaScript -->
<script type="text/javascript" src="<?php echo assets('js/board.js');?>" defer></script>
<script>

    var g = {
        SROOT: "<?php echo urlHtml('/')?>",
        boardID: "<?php echo $boardId;?>",
        columnsModel: "column",
        cardsModel: "card",
        cardsTitleModel: "card/title",
        cardsDescriptionModel: "card/description",
        cardChecklistItemsModel: "item"
    };

</script>
