<?php
class CommentRepository extends BaseRepository
{
    /**
     * getCommentsByProductId: lấy tra thông tin bình luận của một sản phẩm
     *
     * @return void
     */
    public function getCommentsByProductId()
    {
        $query = " SELECT C.content, C.create_at, U.name FROM comments C, users U WHERE C.user_id = U.id AND product_id = " . $_SESSION['product_id'];
        return $this->get_data($query);
    }

    /**
     * createComment: Tạo nhận xét
     *
     * @param [type] $content
     * @return void
     */
    public function createComment($content)
    {
        if(!isset($_SESSION['role'])) {
            echo '<script>alert("Bạn cần đăng nhập trước khi nhận xét !")</script>';
            return;
        }
        $result = $this->insert('comments', [
            'user_id' => $_SESSION['id'],
            'product_id' => $_SESSION['product_id'],
            'content' => $content,
            'create_at' => date('Ymd'),
            'commentable_type' => 0
        ]);

        if(!$result) {
            echo '<script>alert("Bạn cần đăng nhập trước khi nhận xét !")</script>';
            return;
        }
        echo '<script>alert("Nhận xét thành công !"); window.location="./ProductDetails.php?state=true"</script>';
        return;
        
    }

}