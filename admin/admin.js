document.addEventListener("DOMContentLoaded", function () {
    const cardBodies = document.querySelectorAll(".card-body p:not(.card-text)");
    cardBodies.forEach(body => {
        const fullText = body.textContent.trim();
        const words = fullText.split(" ");

        if (words.length > 15) {
            const truncatedText = words.slice(0, 15).join(" ") + "... ";
            const seeMoreLink = document.createElement("a");
            seeMoreLink.href = "#";
            seeMoreLink.textContent = "See more";
            seeMoreLink.style.textDecoration = "none";
            seeMoreLink.style.color = "black"

            body.textContent = truncatedText;
            body.appendChild(seeMoreLink);

            seeMoreLink.addEventListener("click", function (event) {
                event.preventDefault();
                body.textContent = fullText;
            });
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    var deleteBtn = document.getElementById('confirm-delete-btn');
    var modal = document.getElementById('deletePost');

    modal.addEventListener('show.bs.modal', function (event) {
        var link = event.relatedTarget;
        var announcementId = link.getAttribute('data-announcement-id');
        
        deleteBtn.onclick = function () {
            window.location.href = 'delete_announcement.php?id=' + announcementId;
        };
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('deleted')) {
        var myModal = new bootstrap.Modal(document.getElementById('postDelete'));
        myModal.show();

        setTimeout(function() {
            myModal.hide(); 

            const newUrl = window.location.pathname;
            window.history.replaceState(null, '', newUrl);
        }, 2000);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var deleteBtn = document.getElementById('confirm-delete-student-btn');
    var modal = document.getElementById('deleteStudent');

    modal.addEventListener('show.bs.modal', function (event) {
        var link = event.relatedTarget;
        var studentId = link.getAttribute('data-student-id');
        
        deleteBtn.onclick = function () {
            window.location.href = 'delete_student.php?id=' + studentId;
        };
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('deleted')) {
        var myModal = new bootstrap.Modal(document.getElementById('studentDelete'));
        myModal.show();

        setTimeout(function() {
            myModal.hide(); 

            const newUrl = window.location.pathname;
            window.history.replaceState(null, '', newUrl);
        }, 2000);
    }
});