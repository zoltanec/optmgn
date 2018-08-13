<?php
/**
 * Interface for objects with can be commentable
 *  ...
 * @author Unknown
 *
 */

interface Comments_Commentable {
	/**
	 * Increment comments number
	 *
	 * @param Comments_Comment $comment - comment which was added
	 * @param Comments_Meta $meta - comments meta information for this object
	 */
	public function comInc(Comments_Comment $comment, Comments_Meta $meta);

	/**
	 * Decrement comments number
	 *
	 * @param Comments_Meta $meta - comments meta information
	 */
	public function comDec(Comments_Meta $meta);

	/**
	 * Set comments data from Comments_meta object
	 *
	 * @param Comments_Meta $meta - current object comments_meta
	 */
	public function comSet(Comments_Meta $meta);

}
?>