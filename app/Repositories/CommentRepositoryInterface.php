<?php

namespace  App\Repositories;


interface CommentRepositoryInterface
{
   public function getComments($postId);
   public function store($postId, $userId, $content);
   public function edit($commentId);
   public function update($commentId, $content);
   public function delete($id);
}
