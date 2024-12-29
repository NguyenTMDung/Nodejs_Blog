<?php
//Mã QR THANH TOÁN
// Add custom Theme Functions here
add_action('woocommerce_thankyou_bacs', function($order_id){
    $bacs_info = get_option('woocommerce_bacs_accounts');
    if(!empty($bacs_info) && count($bacs_info) > 0):
        $order = wc_get_order( $order_id );
        $content = 'Don hang ' . $order->get_order_number(); // Nội dung chuyển khoản
    ?>
        <div class="vdh_qr_code">
	    <?php foreach($bacs_info as $item): ?>
	    <span class="vdh_bank_item">
	        <img class="img_qr_code" src="https://img.vietqr.io/image/<?php echo $item['bank_name']?>-<?php echo $item['account_number']?>-print.jpg?amount=<?php echo $order->get_total() ?>&addInfo=<?php echo $content ?>&accountName=<?php echo $item['account_name']?>" alt="QR Code">
	    </span>
	    <?php endforeach; ?>

            <div id="modal_qr_code" class="modal">
	        <img class="modal-content" id="img01">
	    </div>
        </div>

	<style>
	    .vdh_qr_code{justify-content:space-between;display:flex}.vdh_qr_code .vdh_bank_item{width:400px;display:inline-block}.vdh_qr_code .vdh_bank_item img{width:100%}.vdh_qr_code .img_qr_code{border-radius:5px;cursor:pointer;transition:.3s;display:block;margin-left:auto;margin-right:auto}.vdh_qr_code .img_qr_code:hover{opacity:.7}.vdh_qr_code .modal{display:none;position:fixed;z-index:999999;left:0;top:0;width:100%;height:100%;background-color:rgba(0,0,0,.9)}.vdh_qr_code .modal-content{margin:auto;display:block;height:100%}.vdh_qr_code #caption{margin:auto;display:block;width:80%;max-width:700px;text-align:center;color:#ccc;padding:10px 0;height:150px}.vdh_qr_code #caption,.vdh_qr_code .modal-content{-webkit-animation-name:zoom;-webkit-animation-duration:.6s;animation-name:zoom;animation-duration:.6s}.vdh_qr_code .out{animation-name:zoom-out;animation-duration:.6s}@-webkit-keyframes zoom{from{-webkit-transform:scale(1)}to{-webkit-transform:scale(2)}}@keyframes zoom{from{transform:scale(.4)}to{transform:scale(1)}}@keyframes zoom-out{from{transform:scale(1)}to{transform:scale(0)}}.vdh_qr_code .close{position:absolute;top:15px;right:35px;color:#f1f1f1;font-size:40px;font-weight:700;transition:.3s}.vdh_qr_code .close:focus,.vdh_qr_code .close:hover{color:#bbb;text-decoration:none;cursor:pointer}@media only screen and (max-width:768px){.vdh_qr_code .modal-content{height:auto}}
	</style>

	<script>
	    const modal = document.getElementById('modal_qr_code');
	    const modalImg = document.getElementById("img01");
	    var img = document.querySelectorAll('.img_qr_code');
	    for (var i=0; i<img.length; i++){
	        img[i].onclick = function(){
		    modal.style.display = "block";
		    modalImg.src = this.src;
		    modalImg.alt = this.alt;
		}
	    }
	    modal.onclick = function() {
	        img01.className += " out";
		setTimeout(function() {
		    modal.style.display = "none";
		    img01.className = "modal-content";
		}, 400);
	    }
	</script>
    <?php
    endif;
});

//Tự động cập nhật đơn hàng

add_action('woocommerce_thankyou', 'update_order_status_to_completed', 10, 1);

function update_order_status_to_completed($order_id) {
    // Kiểm tra xem $order_id có hợp lệ không
    if (!$order_id) {
        return;
    }

    // Lấy đối tượng đơn hàng từ $order_id
    $order = wc_get_order($order_id);

    // Kiểm tra xem đối tượng đơn hàng có hợp lệ không
    if ($order instanceof WC_Order) {
        // Đặt trạng thái đơn hàng thành "đã nhận"
        $payment_method = $order->get_payment_method();

        // Nếu phương thức thanh toán là "ngân hàng" (giả sử mã là "bacs")
        if ($payment_method === 'bacs') {
            // Đặt trạng thái đơn hàng thành "paid"
            $order->update_status('paid', 'Đơn hàng đã thanh toán qua ngân hàng.');
        } else {
            // Đặt trạng thái khác nếu cần, ví dụ: "đã nhận"
            $order->update_status('2', 'Đơn hàng đã được nhận.');
        }
    }
}


// Thêm nút đánh giá vào lịch sử mua hàng
add_action('woocommerce_order_details_after_order_table', 'add_review_button_to_order_history');

function add_review_button_to_order_history($order) {
    // Kiểm tra xem đơn hàng đã hoàn thành chưa
    if ($order->get_status() === 'completed') {
        // Tạo một nút đánh giá cho toàn bộ đơn hàng
        echo '<div class="order-review-section">';
        echo '<h2>Đánh giá đơn hàng của bạn</h2>';
        echo '<a href="' . esc_url(add_query_arg(['order_id' => $order->get_id()], site_url('/danh-gia-don-hang'))) . '" class="button" style="background-color: #28a745; color: #fff; padding: 5px 10px; border-radius: 5px; text-decoration: none;">Đánh giá đơn hàng</a>';
        echo '</div>';
    }
}

add_filter('woocommerce_my_account_my_orders_columns', 'remove_bank_column_from_orders_table', 10, 1);
function remove_bank_column_from_orders_table($columns) {
    // Xóa cột 'ngân hàng' khỏi bảng đơn hàng
    unset($columns['ttqr_bank']); // 'ttqr_bank' là khóa cột của bạn, bạn cần thay bằng khóa đúng
    return $columns;
}

// Thêm cột 'Đánh giá' vào bảng đơn hàng 
add_filter('woocommerce_my_account_my_orders_columns', 'add_review_button_column', 10, 1);
function add_review_button_column($columns) {
    // Thêm cột 'Đánh giá' sau cột 'actions'
    $columns['review'] = 'Đánh giá'; // Tạo cột 'Đánh giá'
    return $columns;
}
// Hiển thị nút đánh giá trong cột 'Đánh giá'
add_action('woocommerce_my_account_my_orders_column_review', 'add_review_button_to_order_actions', 10, 1);
function add_review_button_to_order_actions($order) {
    // echo $order->get_status();
    // Kiểm tra trạng thái đơn hàng là 'completed'
    if ($order->get_status() === 'completed') {
        // Lấy ID đơn hàng
        $order_id = $order->get_id();
        
        // Tạo nút đánh giá đơn hàng
        echo '<a href="' . esc_url(add_query_arg(['order_id' => $order_id], site_url('/danh-gia-don-hang'))) . '" class="button" style="background-color: #28a745; color: #fff; border-radius: 5px; text-decoration: none; width: 110px; margin: 0;">Đánh giá</a>';
    }
}

add_shortcode('submit_review_form', 'render_submit_review_form');
add_shortcode('add_font_awesome', 'add_font_awesome');

function add_font_awesome() {
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
    }
    add_action('wp_enqueue_scripts', 'add_font_awesome');


function render_submit_review_form() {
    if (!isset($_GET['order_id'])) {
        return '<p>Không có đơn hàng nào được chọn để đánh giá.</p>';
    }

    $order_id = intval($_GET['order_id']);
    $order = wc_get_order($order_id);

    if (!$order) {
        return '<p>Đơn hàng không tồn tại.</p>';
    }

    // Kiểm tra nếu đơn hàng đã được hoàn thành
    if ($order->get_status() !== 'completed') {
        return '<p>Đơn hàng chưa hoàn thành, không thể đánh giá.</p>';
    }

    // Lặp qua các sản phẩm trong đơn hàng
    
    $output = '<div id="notification" style="{padding: 10px;margin: 20px 0;border-radius: 5px;font-size: 16px;font-weight: bold;}"></div>';
    $output = '<h2 style= "margin-top: 10px;">Đánh giá các sản phẩm trong đơn hàng #' . $order_id . '</h2>';
    foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();
        $product_id = $product->get_id();

        // Form đánh giá cho từng sản phẩm
        $output .= '<div class="review-product-form">';
        $output .= '<h2>Sản phẩm: ' . $product->get_name() . '</h2>';
        // Lấy ảnh sản phẩm
        $product_image = $product->get_image(); // Trả về thẻ <img>

        // Thêm ảnh sản phẩm vào HTML
        $output .= '<div class="product-image">' . $product_image . '</div>';
        $output .= '<form action="" method="post" enctype="multipart/form-data">';
        
        // Sao
        $output .= '<label style="margin-top: 10px; font-size: 22px;">Bạn cho bao nhiêu sao?</label>';
        $output .= '<div class="star-ratingg" data-product-id="' . $product_id . '" style="margin-top: -65px;">';
        for ($i = 1; $i <= 5; $i++) {
            // Thêm $product_id vào name để tránh trùng lặp
            $output .= '<input class="star star-' . $i . '" id="star-' . $product_id . '-' . $i . '" type="radio" name="star_' . $product_id . '" value="' . $i . '"/>';
            $output .= '<label class="star star-' . $i . '" for="star-' . $product_id . '-' . $i . '"></label>'; // Sử dụng ký tự ngôi sao rỗng
        }
        $output .= '</div>';

        // Bình luận
        $output .= '<label for="comment_' . $product_id . '" style="margin-top: 100px; font-size: 22px;">Bình luận:</label>';
        $output .= '<textarea name="comment_' . $product_id . '" id="comment_' . $product_id . '" rows="4" required></textarea>';

        // Tải ảnh/video
        // $output .= '<label for="review_media_' . $product_id . '" style="margin-top: 20px; font-size: 22px;">Tải ảnh/video lên:</label>';
        // $output .= '<input type="file" name="review_media_' . $product_id . '[]" id="review_media_' . $product_id . '" accept="image/*, video/*" multiple>';
        // $output .= '<div id="preview_' . $product_id . '" class="media-preview"></div>';

        // Thêm input ẩn cho product_id
        $output .= '<input type="hidden" name="product_id_' . $product_id . '" value="' . $product_id . '">';
        
        // Nút gửi đánh giá
        $output .= '<button type="submit" name="submit_review_' . $product_id . '" style="margin-top: 20px; font-size: 17px; border: 1px solid black; border-radius: 15px;">Gửi đánh giá</button>';
        
        $output .= '</form>';
        $output .= '</div>';
    }

    return $output;
}

function add_custom_js() {
    if (is_page('danh-gia-don-hang')) { 
        wp_enqueue_script('custom-review-script', get_stylesheet_directory_uri() . '/review.js', array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'add_custom_js');

function handle_review_submission() {
    // Kiểm tra nếu có dữ liệu POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lặp qua từng sản phẩm trong biểu mẫu
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'submit_review_') === 0) {
                $product_id = intval(str_replace('submit_review_', '', $key));

                // Lấy dữ liệu từ biểu mẫu
                $rating = isset($_POST['star_' . $product_id]) ? intval($_POST['star_' . $product_id]) : 0;
                $comment = isset($_POST['comment_' . $product_id]) ? sanitize_text_field($_POST['comment_' . $product_id]) : '';

                // Kiểm tra các điều kiện
                if ($rating < 1 || $rating > 5) {
                    echo '<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            alert("Số sao không hợp lệ.");
        });
      </script>';
                    return;
                }

                // Thêm đánh giá sản phẩm
                $review_data = [
                    'comment_post_ID' => $product_id,
                    'comment_author' => wp_get_current_user()->display_name,
                    'comment_author_email' => wp_get_current_user()->user_email,
                    'comment_content' => $comment,
                    'comment_type' => 'review',
                    'comment_approved' => 0, // Chờ phê duyệt
                ];

                // Tạo đánh giá
                $comment_id = wp_insert_comment($review_data);

                if ($comment_id) {
                    update_comment_meta($comment_id, 'rating', 6-$rating);
                    echo '<script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function() {
                            alert("Đánh giá đã được gửi");
                        });
                    </script>';
                } else {
                    echo '<script type="text/javascript">
                        document.addEventListener("DOMContentLoaded", function() {
                            alert("Có lỗi xảy ra vui lòng thử lại");
                        });
                    </script>';
                }

                // Xử lý tải lên tệp (nếu có)
                if (!empty($_FILES['review_media_' . $product_id]['name'][0])) {
                    handle_review_media_upload($_FILES['review_media_' . $product_id], $comment_id);
                }
                return; // Dừng vòng lặp khi đã xử lý một sản phẩm
            }
        }
    }
}
add_action('init', 'handle_review_submission');
function handle_review_media_upload($files, $comment_id) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
    
    // Lấy đường dẫn thư mục tải lên của WordPress
    $upload_dir = wp_upload_dir();
    $uploaded_files = [];

    // Lặp qua các tệp đã tải lên
    foreach ($files['name'] as $index => $name) {
        if ($files['error'][$index] === UPLOAD_ERR_OK) {
            // Tạo mảng chứa thông tin tệp tải lên
            $file = [
                'name'     => $files['name'][$index],
                'type'     => $files['type'][$index],
                'tmp_name' => $files['tmp_name'][$index],
                'error'    => $files['error'][$index],
                'size'     => $files['size'][$index],
            ];

            // Xử lý tệp và nhận đường dẫn
            $upload = wp_handle_upload($file, ['test_form' => false]);

            // Kiểm tra nếu có lỗi trong quá trình tải lên
            if (isset($upload['error'])) {
                // Nếu có lỗi, in ra thông báo lỗi
                echo 'Error: ' . $upload['error'];
            } elseif (isset($upload['url'])) {
                // Nếu tải lên thành công, thêm URL tệp vào mảng
                $uploaded_files[] = $upload['url'];
            }
        }
    }

    // Lưu các URL tệp vào meta của comment
    if (!empty($uploaded_files)) {
        update_comment_meta($comment_id, 'review_media', $uploaded_files);
    }
}

//Hiển thị trong sửa đánh giá của admin
function display_review_media_in_comment_edit($comment) {
    $review_media = get_comment_meta($comment->comment_ID, 'review_media', true);
    echo '<p>Hook is working</p>';

    // Nếu có các tệp media được tải lên, hiển thị chúng
    if (!empty($review_media)) {
        echo '<div class="review-media">';
        echo '<h4>' . __('Review Media', 'text-domain') . '</h4>';
        foreach ($review_media as $media_url) {
            echo '<p><a href="' . esc_url($media_url) . '" target="_blank">' . __('View Image', 'text-domain') . '</a></p>';
        }
        echo '</div>';
    }
}
add_action('edit_comment', 'display_review_media_in_comment_edit');
add_action('comment_form_top', 'display_review_media_in_comment_edit');



