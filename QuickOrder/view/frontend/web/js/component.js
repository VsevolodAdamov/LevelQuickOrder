require(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function(
        $,
        modal
    ) {
        let options = {
            type: 'popup',
            responsive: true,
            title: 'Quick order',
            innerScroll: true,
            buttons: [{
                text: $.mage.__('Send'),
                class: 'mymodal1',
                click: function () {
                    this.closeModal();
                }
            }]
        };

        let popup = modal(options, $('#popup-modal'));
        $(".btn-btn-primary").on('click',function(){
            $("#popup-modal").modal("openModal");
        });
    }
);