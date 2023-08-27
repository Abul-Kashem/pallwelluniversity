import $ from 'jquery'

class MyNotes {

    constructor() {
        this.events()
    }

    events() {
        $("#my-notes").on("click", ".delete-note", this.deleteNote);
        $('#my-notes').on("click", ".edit-note", this.editNote.bind(this));
        $('#my-notes').on("click", ".update-note", this.updateNote.bind(this));
        $('.submit-note').on("click", this.createNote.bind(this));
    }

    // method start here

    createNote(e) {

        var our_new_note = {
            "title": $(".new-note-title").val(),
            "content": $(".new-note-body").val(),
            "status": "publish"
        }

        $.ajax({

            beforeSend: xhr => {
                xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
            },
            url: universityData.root_url + "/wp-json/wp/v2/note/",
            type: "POST",
            data: our_new_note,
            success: response => {
                // this.makeNewNote();

                $(".new-note-title, .new-note-body").val("");
                $(`
                    <li data-id="${response.id}">
                        <input class="note-title-field" value="${response.title.raw}">
                        <span class="edit-note"><i class="fa fa-pencil"></i>Edit</span>
                        <span class="delete-note"><i class="fa fa-pencil"></i>Delete</span>
                        <textarea class="note-body-field">${response.content.raw}</textarea>
                        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                    </li>
                `).prependTo("#my-notes").hide().slideDown();
                console.log("congrats")
                console.log(response)
            },
            error: response => {
                if (response.responseText == "You have reached your note limit.") {
                    $(".note-limit-message").addClass("active");
                }
                console.log("Sorry!");
                console.log(response)
            }
        })
    }

    makeNewNote(response) {
        console.log(response);
        $(".new-note-title, .new-note-body").val("");
        $(`
            <li data-id="${response.id}">
                <input class="note-title-field" value="${response.title.raw}">
                <span class="edit-note"><i class="fa fa-pencil"></i>Edit</span>
                <span class="delete-note"><i class="fa fa-pencil"></i>Delete</span>
                <textarea class="note-body-field">${response.content.raw}</textarea>
                <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
            </li>
        `).prependTo("#my-notes").hide().slideDown();
    }

    // edit method
    editNote(e) {
        var this_note = $(e.target).parents('li');
        if (this_note.data('state') == 'editable') {
            this.makeNoteReadOnly(this_note);
        } else {
            this.makeNoteEditable(this_note);
        }
    }
    makeNoteEditable(this_note) {
        this_note.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i>Cancel');
        this_note.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        this_note.find(".update-note").addClass("update-note--visible");
        this_note.data("state", "editable");
    }

    makeNoteReadOnly(this_note) {
        this_note.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i>Edit');
        this_note.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
        this_note.find(".update-note").removeClass("update-note--visible");
        this_note.data("state", "cancel");
    }

    // update method
    updateNote(e) {
        var this_note = $(e.target).parents('li');

        var our_update_note = {
            "title": this_note.find(".note-title-field").val(),
            "content": this_note.find(".note-body-field").val()
        }

        $.ajax({

            beforeSend: xhr => {
                xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
            },
            url: universityData.root_url + "/wp-json/wp/v2/note/" + this_note.data('id'),
            type: "POST",
            data: our_update_note,
            success: response => {
                this.makeNoteReadOnly(this_note);
                console.log("congrats")
                console.log(response)
            },
            error: response => {
                console.log("Sorry!");
                console.log(response)
            }
        })

    }

    // delete method
    deleteNote(e) {
        var this_note = $(e.target).parents('li');

        $.ajax({

            beforeSend: xhr => {
                xhr.setRequestHeader("X-WP-Nonce", universityData.nonce)
            },
            url: universityData.root_url + "/wp-json/wp/v2/note/" + this_note.data('id'),
            type: "DELETE",
            success: response => {
                this_note.slideUp();
                console.log("congrats")
                console.log(response)
            },
            error: response => {
                console.log("Sorry!");
                console.log(response)
            }
        })
    }
}
export default MyNotes;