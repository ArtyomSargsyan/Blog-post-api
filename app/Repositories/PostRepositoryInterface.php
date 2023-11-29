<?php

namespace  App\Repositories;

interface PostRepositoryInterface
{
   public function allPosts();
   public function edit($postId);
   public function store($path, $languages);
   public function delete($id);
}
