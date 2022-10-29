<div class="dropdown-menu d-block position-static pt-0 mx-0 rounded-3 shadow overflow-hidden w-280px">
    <form method="POST" class="p-2 mb-2 bg-light border-bottom" action="{{ route('tag.store') }}" enctype="multipart/form-data" id="add-tag-form">
        @csrf
        <div class="autocomplete">
            <div class="row">
                <div class="col-9">
                    <input type="text" autocomplete="off" class="form-control tags" id="myInput" name="myTags"
                        placeholder="Type to find..." required>
                </div>
                <div class="col-3">
                    <button id="createTag" onclick="sendData()" type="submit" class="btn btn-outline-primary">Add tag</button>
                </div>
            </div>
        </div>
        @if (isset($post))
            <input type="hidden" name="post_id" value="{{ $post->id }}">
        @else
            <input type="hidden" id="hiddenTitle" name="title" value="">
            <input type="hidden" id="hiddenContent" name="content" value="">
        @endif
    </form>
    <ul id="tags-dropdown-menu" class="list-unstyled mb-0 d-block">
        @if(isset($post))
            @foreach ($post->tags as $tag)
                <li>
                    <div class="dropdown-item d-flex align-items-center gap-2 py-2">
                        <span class="d-inline-block bg-primary rounded-circle p-1"></span>
                        {{ $tag->name }}
                        {{-- <a href="{{ route('post_tag.delete', ['post_id' => $post->id, 'tag_id' => $tag->id]) }}">
                            <span class="d-inline-block text-3xl text-danger p-1">-</span>
                        </a> --}}
                        <form action="{{ route('post_tag.delete', ['post_id' => $post->id, 'tag_id' => $tag->id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="ms-1 btn-link link-danger">Remove Tag</button>
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="tag_id" value="{{ $tag->id }}">
                        </form>
                    </div>
                </li>
                <input type="hidden" class="tag" name="tag_id" value="{{ $tag->id }}">
            @endforeach
        @endif
    </ul>
</div>

<script>
    $(document).ready(function(){

        var form = '#add-tag-form';

        $(form).on('submit', function(event){
            event.preventDefault();

            var url = $(this).attr('action');

            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(response)
                {
                    $(form).trigger("reset");
                    alert(response.success)
                },
                error: function(response) {
                }
            });
        });

    });
    title.onblur = function() {
        hiddenTitle.value = title.value
    }

    content.onblur = function() {
        hiddenContent.value = content.value
    }
    autocompleteTags();
    async function autocompleteTags() {
        let tags = await getTags();
        autocomplete(document.getElementById("myInput"), tags['allTags']);
    }
    // let dropMenu = false
    // document.addEventListener('click', function(e) {
    //     if (e.target.classList.contains('tags')) {
    //         dropMenu = !dropMenu
    //     }
    //     if (dropMenu) {
    //         document.getElementById('tags-dropdown-menu').className = 'd-block'
    //     } else {
    //         document.getElementById('tags-dropdown-menu').className = 'd-none'
    //     }
    // })
    async function getTags() {
        try {
            let url = '/api';
            let response = await fetch(url);
            let json = await response.json();
            return JSON.parse(json);
        } catch {
            alert('Ошибка, данные не получены.')
        }
    }



    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    b.setAttribute("class", "mt-2 text-primary");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("text-danger");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("text-danger");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }
</script>
