<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Fanky\Admin\Models\SettingGroup
 *
 * @property int $id
 * @property int $page_id
 * @property string $name
 * @property string|null $description
 * @property int $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\Fanky\Admin\Models\Setting[] $settings
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\SettingGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\SettingGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\SettingGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\SettingGroup whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\SettingGroup wherePageId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\SettingGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\SettingGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\SettingGroup query()
 */
class SettingGroup extends Model {

	protected $table = 'settings_groups';

	public $timestamps = false;

	protected $fillable = ['name', 'description', 'order'];

	public function settings()
	{
		return $this->hasMany('Fanky\Admin\Models\Setting', 'group_id');
	}
}
