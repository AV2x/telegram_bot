<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    public $timestamps = null;
    protected $fillable = ['role_id','analytics_graphics','analytics_pie','orders_create',
        'orders_edit','orders_delete','orders_view','orders_export','orders_status',
        'users_create','users_edit','users_delete','users_view','roles_create','roles_edit',
        'roles_delete','roles_view','roles_attach','roles_detach','categories_create',
        'categories_edit','categories_delete','categories_view','products_create',
        'products_edit','products_delete','products_view','products_import','products_export',
        'settings_view','settings_statuses_view','settings_statuses_create',
        'settings_statuses_edit','settings_statuses_delete','settings_requisites_view',
        'settings_requisites_edit','settings_properties_view','settings_properties_create',
        'settings_properties_edit','settings_properties_delete','settings_storage_view',
        'settings_storage_create','settings_storage_delete','settings_telegram_view',
        'settings_telegram_link', 'orders_executor'
        ];
}
