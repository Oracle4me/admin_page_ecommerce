function badgeAction(inputSelector, containerSelector, hiddenSelector) {
    const $input = $(inputSelector);
    const $container = $(containerSelector);
    const $hidden = $(hiddenSelector);

    let tags = [];

    function renderTags() {
        $container.empty();
        tags.forEach((tag, index) => {
            const badge = $(`
                <span class="badge bg-light me-1 mr-2">
                    #${tag} <span class="remove-tag" style="cursor:pointer">&times;</span>
                </span>
            `);
            $container.append(badge);
        });

        // event delete tag
        $container.find('.remove-tag').each(function(i){
            $(this).on('click', function(){
                tags.splice(i, 1);
                renderTags();
            });
        });

        $hidden.val(tags.join(','));
    }

    $input.on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();

            const value = $input.val().trim();

            if (value && !tags.includes(value)) {
                tags.push(value);
                renderTags();
            }

            $input.val('');
        }
    });
}
