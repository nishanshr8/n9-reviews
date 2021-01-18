<?php
/**
 * namespace 
 */
?>

<div>
    <div class="meta-options">
        <label for="n9r-rating-star">Rating:</label>
        <input 
            type="number" 
            max="5" 
            min="0" 
            name="n9r-rating-star"
            id="n9r-rating-star"
            value="<?= get_post_meta( get_the_ID(), 'n9r-rating-star', true); ?>"
        >
    </div>

    <div class="meta-options">
        <label for="n9r-reviews-comment">Comment:</label>
        <textarea 
            name="n9r-reviews-comment" 
            id="n9r-reviews-comment" 
            cols="30" 
            rows="10"
            value="<?= get_post_meta( get_the_ID(), 'n9r-reviews-comment', true); ?>"
        ></textarea>
    </div>

    <div class="meta-options">
        <label for="n9r-comment-visibility">Comment Visibility:</label>
        <input 
            type="checkbox"
            name="n9r-comment-visibility"
            id="n9r-comment-visibility"
            tab-index="-1"
            title="Comment Visibility"
            value="<?= get_post_meta( get_the_ID(), 'n9r-comment-visibility', true ); ?>"
        >
    </div>

</div>