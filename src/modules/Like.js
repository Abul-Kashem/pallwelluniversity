import $ from 'jquery';

class Like {
    constructor() {
        // alert('Testing from like js');
        this.events();
    }

    events() {
        $('.like-box').on('click', this.ourClickDispatcher.bind(this));
    }

    // methods
    ourClickDispatcher(e) {
        var current_like_box = $(e.target).closest('.like-box');

        if (current_like_box.data('exists') == 'yes') {
            this.deleteLike();
        } else {
            this.createLike();
        }
    }

    createLike() {
        alert('create test msg');
    }

    deleteLike() {
        alert('delete test msg');
    }
}
export default Like;