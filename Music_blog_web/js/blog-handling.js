document.addEventListener('DOMContentLoaded', function () {
    var editButtons = document.querySelectorAll('.edit-button');
    editButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var blogId = this.getAttribute('data-blog-id');
            toggleEditMode(blogId);
        });
    });

    var updateButtons = document.querySelectorAll('.update-button');
    updateButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var blogId = this.closest('.edit-form').getAttribute('data-blog-id');
            updatePost(blogId);
        });
    });

    var deleteButtons = document.querySelectorAll('.delete-button');
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var blogId = this.getAttribute('data-blog-id');
            deletePost(blogId);
        });
    });
    
});

function toggleEditMode(blogId) {
    var editForms = document.querySelectorAll('.edit-form');
    editForms.forEach(function (form) {
        form.style.display = 'none';
    });

    var editForm = document.querySelector('.edit-form[data-blog-id="' + blogId + '"]');
    var editButton = document.querySelector('.edit-button[data-blog-id="' + blogId + '"]');
    
    if (editForm.style.display === 'none') {
        // Entering edit mode
        editForm.style.display = 'block';
        editButton.style.display = 'none'; // Hide the "Edit" button
    } else {
        // Exiting edit mode
        editForm.style.display = 'none';
        editButton.style.display = 'block'; // Show the "Edit" button
    }
}

function updatePost(blogId) {
    var form = document.querySelector('.edit-form[data-blog-id="' + blogId + '"] form');
    var formData = new FormData(form);

    // Check if the new_image input is empty
    var newImageInput = form.querySelector('input[name="new_image"]');
    if (newImageInput.files.length === 0) {
        // Remove the new_image key from FormData
        formData.delete('new_image');
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_post.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            // Reload the page or update the blog post content dynamically
            // You can replace this with your desired logic
            location.reload();
        }
    };
    xhr.send(formData);
}

function deletePost(blogId) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'delete_post.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            // Reload the page or update the blog post content dynamically
            // You can replace this with your desired logic
            location.reload();
        }
    };
    xhr.send('blog_id=' + blogId);
}



document.addEventListener('DOMContentLoaded', function () {
    // Attach event listener to like buttons
    document.querySelectorAll('.like-button').forEach(function (button) {
        button.addEventListener('click', function () {
            // Get the blog ID from the button's data attribute
            var blogId = this.getAttribute('data-blog-id');

            // Check if the blog is already liked
            var isLiked = localStorage.getItem('liked_blog_' + getUserId() + '_' + blogId) === '1';

            // Send an AJAX request to update the likes_count in the database
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'handlers/like_post.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Parse the JSON response
                        var response = JSON.parse(xhr.responseText);

                        // Update the likes count on the page
                        var likesCountElement = document.querySelector('.blog-post[data-blog-id="' + blogId + '"] .likes-count');
                        likesCountElement.textContent = response.likes_count + ' likes';

                        // Update the like button style based on the like status
                        var likeButton = document.querySelector('.blog-post[data-blog-id="' + blogId + '"] .like-button');
                        var isLikedNow = response.like_status === 1;

                        likeButton.classList.toggle('liked', isLikedNow);

                        // Update localStorage to persist the liked status
                        localStorage.setItem('liked_blog_' + blogId, isLikedNow ? '1' : '0');
                    } else {
                        // Handle errors or already liked/unliked case
                        console.error('Error:', xhr.responseText);
                        // You may want to display an error message or handle it differently
                    }
                }
            };
            xhr.send('blog_id=' + blogId);
        });
    });

    // Restore liked status on page load
    document.querySelectorAll('.like-button').forEach(function (button) {
        var blogId = button.getAttribute('data-blog-id');
        var isLiked = localStorage.getItem('liked_blog_' + getUserId() + '_' + blogId) === '1';
        button.classList.toggle('liked', isLiked);
    });

    // Function to get the user ID from the page (modify it based on how you retrieve the user ID)
    function getUserId() {
        return document.querySelector('#user-id-input').value; // Assuming you have a hidden input with user ID
    }
});