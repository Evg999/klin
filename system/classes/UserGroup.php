<?php

// namespace Nordic\Core;
// Для отбражения в админ к какой группе пренодлежит юзер

class UserGroup extends Unit
{
    public function setTable(){
        return 'core_user_groups';
    }
}