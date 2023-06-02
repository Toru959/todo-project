function add_Bookmark(taskId, userId) {
    // CSRFトークンの取得
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // ブックマークの付け外しの操作をサーバーに送信 
    $.ajax({
        url: '/todo/bookmark/store_destroy', // ルートのURL
        type: 'POST',
        data: {
            task_id: taskId,
            user_id: userId // ブックマークIDをデータとして送信
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            // レスポンスを処理
            if (response.status === 'success') {
                if (response.action === 'add') {
                    // ブックマークが追加された場合の処理
                    var bookmarkButton= $('#bookmark'+taskId);
                    bookmarkButton.removeClass('far fa-bookmark fa-lg'); // far-bookmarkクラスを削除
                    bookmarkButton.addClass('fas fa-bookmark fa-lg'); // fas-bookmarkクラスを追加
                } else if (response.action === 'remove') {
                    // ブックマークが削除された場合の処理
                    var bookmarkButton = $('#bookmark'+taskId);
                    bookmarkButton.removeClass('fas fa-bookmark fa-lg'); // fas-bookmarkクラスを削除
                    bookmarkButton.addClass('far fa-bookmark fa-lg'); // far-bookmarkクラスを追加
                }
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseJSON.message);
        }
    });
}

// $(document).ready(function() {
//   $('.bookmark-button').click(function() {
//     var taskId = $(this).data('task-id');
//     var userId =' {{ auth()->user()->id }}';
//     var csrfToken = $('meta[name="csrf-token"]').attr('content');

//     $.ajax({
//       url: '/todo/bookmark/store_destroy',
//       type: 'POST',
//       data: {
//         task_id: taskId,
//         user_id: userId
//       },
//       headers: {
//         'X-CSRF-TOKEN': csrfToken
//       },
//       success: function(response) {
//         if (response.status === 'success') {
//           if (response.action === 'add') {
//             // ブックマークが追加された場合の処理
//             $(this).find('i').removeClass('far fa-bookmark fa-lg');
//             $(this).find('i').addClass('fas fa-bookmark fa-lg');
//           } else if (response.action === 'remove') {
//             // ブックマークが削除された場合の処理
//             $(this).find('i').removeClass('fas fa-bookmark fa-lg');
//             $(this).find('i').addClass('far fa-bookmark fa-lg');
//           }
//         }
//       },
//       error: function(xhr, status, error) {
//         console.log(xhr.responseJSON.message);
//       }
//     });
//   });
// });
