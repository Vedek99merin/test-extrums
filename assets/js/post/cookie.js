document.addEventListener("DOMContentLoaded", function () {
  if (post_data.postType === "post") {
    var postId = post_data.postId;
    document.cookie = "last_visited_post_id=" + postId + "; path=/";
  }
});
