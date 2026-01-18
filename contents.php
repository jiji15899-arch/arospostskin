<?php
/**
 * 댓글 템플릿
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    
    <?php if (have_comments()) : ?>
        
        <h2 class="comments-title">
            💬 댓글 
            <span class="comments-count"><?php echo get_comments_number(); ?>개</span>
        </h2>
        
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style' => 'ol',
                'short_ping' => true,
                'avatar_size' => 50,
                'callback' => 'abaek_custom_comment'
            ));
            ?>
        </ol>
        
        <?php
        if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
            <nav class="comment-navigation">
                <div class="nav-previous"><?php previous_comments_link('← 이전 댓글'); ?></div>
                <div class="nav-next"><?php next_comments_link('다음 댓글 →'); ?></div>
            </nav>
        <?php endif; ?>
        
    <?php endif; ?>
    
    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments">댓글이 닫혔습니다.</p>
    <?php endif; ?>
    
    <?php
    $comment_form_args = array(
        'title_reply' => '✍️ 댓글 남기기',
        'title_reply_to' => '%s님에게 답글',
        'cancel_reply_link' => '답글 취소',
        'label_submit' => '댓글 등록',
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="6" placeholder="댓글을 입력하세요..." required></textarea></p>',
        'fields' => array(
            'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" placeholder="이름 *" required /></p>',
            'email' => '<p class="comment-form-email"><input id="email" name="email" type="email" placeholder="이메일 *" required /></p>',
            'url' => '<p class="comment-form-url"><input id="url" name="url" type="url" placeholder="웹사이트 (선택)" /></p>',
        ),
        'class_submit' => 'submit-button',
        'submit_button' => '<button type="submit" class="submit-button">%4$s</button>',
    );
    
    comment_form($comment_form_args);
    ?>
    
</div>

<?php
// 커스텀 댓글 디자인
function abaek_custom_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <article class="comment-body">
            <div class="comment-author-avatar">
                <?php echo get_avatar($comment, 50); ?>
            </div>
            
            <div class="comment-content-wrap">
                <div class="comment-meta">
                    <div class="comment-author-name">
                        <?php echo get_comment_author_link(); ?>
                        <?php if ($comment->user_id === get_post()->post_author) : ?>
                            <span class="author-badge">작성자</span>
                        <?php endif; ?>
                    </div>
                    <div class="comment-metadata">
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php printf('%s 전', human_time_diff(get_comment_time('U'), current_time('timestamp'))); ?>
                        </time>
                    </div>
                </div>
                
                <div class="comment-text">
                    <?php if ($comment->comment_approved == '0') : ?>
                        <em class="comment-awaiting-moderation">댓글이 승인 대기 중입니다.</em>
                    <?php endif; ?>
                    <?php comment_text(); ?>
                </div>
                
                <div class="comment-actions">
                    <?php
                    comment_reply_link(array_merge($args, array(
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => '↩️ 답글'
                    )));
                    ?>
                    
                    <?php edit_comment_link('✏️ 수정', '<span class="edit-link">', '</span>'); ?>
                </div>
            </div>
        </article>
    <?php
}
?>

<style>
.comments-area {
    max-width: 800px;
    margin: 60px auto 0;
    padding: 40px 20px;
    background: var(--light-gray);
    border-radius: 16px;
}

.comments-title {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 30px;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 10px;
}

.comments-count {
    font-size: 18px;
    color: var(--primary-color);
}

.comment-list {
    list-style: none;
    padding: 0;
    margin: 0 0 40px 0;
}

.comment-list li {
    margin-bottom: 25px;
}

.comment-body {
    display: flex;
    gap: 15px;
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.comment-author-avatar img {
    border-radius: 50%;
    width: 50px;
    height: 50px;
}

.comment-content-wrap {
    flex: 1;
}

.comment-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.comment-author-name {
    font-weight: 700;
    color: var(--text-color);
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.comment-author-name a {
    text-decoration: none;
    color: inherit;
}

.author-badge {
    display: inline-block;
    padding: 2px 8px;
    background: var(--primary-color);
    color: white;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
}

.comment-metadata {
    font-size: 13px;
    color: #a0aec0;
}

.comment-text {
    margin-bottom: 12px;
    line-height: 1.7;
    color: var(--text-color);
}

.comment-awaiting-moderation {
    display: block;
    padding: 10px;
    background: #fef3c7;
    color: #92400e;
    border-radius: 6px;
    margin-bottom: 10px;
    font-size: 14px;
}

.comment-actions {
    display: flex;
    gap: 15px;
    font-size: 14px;
}

.comment-actions a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
}

.comment-actions a:hover {
    color: var(--secondary-color);
}

/* 대댓글 */
.children {
    list-style: none;
    padding-left: 40px;
    margin-top: 20px;
}

/* 댓글 폼 */
.comment-respond {
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.comment-reply-title {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 25px;
    color: var(--text-color);
}

.comment-form p {
    margin-bottom: 15px;
}

.comment-form input[type="text"],
.comment-form input[type="email"],
.comment-form input[type="url"],
.comment-form textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 15px;
    font-family: inherit;
    transition: var(--transition);
}

.comment-form input:focus,
.comment-form textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.comment-form textarea {
    resize: vertical;
    min-height: 120px;
}

.submit-button {
    width: 100%;
    padding: 14px;
    background: var(--button-gradient);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
}

.submit-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.comment-navigation {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 2px solid var(--border-color);
}

.comment-navigation a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
}

.comment-navigation a:hover {
    color: var(--secondary-color);
}

.no-comments {
    text-align: center;
    padding: 40px;
    color: #718096;
    font-style: italic;
}

@media (max-width: 768px) {
    .comments-area {
        padding: 30px 15px;
    }
    
    .comment-body {
        flex-direction: column;
    }
    
    .children {
        padding-left: 20px;
    }
    
    .comment-respond {
        padding: 20px;
    }
}
</style>
