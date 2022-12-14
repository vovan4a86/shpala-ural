<?php namespace Fanky\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Fanky\Admin\Models\Setting
 *
 * @property int $id
 * @property int $group_id
 * @property string $code
 * @property string $name
 * @property string|null $description
 * @property array $params
 * @property string|null $value
 * @property int $type
 * @property int $order
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Fanky\Admin\Models\SettingGroup $group
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting whereValue($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Fanky\Admin\Models\Setting query()
 */
class Setting extends Model {

	protected $table = 'settings';

	protected $fillable = ['group_id', 'code', 'name', 'description', 'params', 'value', 'type', 'order'];

	protected $casts = [
		'params' => 'array',
	];

	const UPLOAD_PATH = '/public/uploads/settings/';
	const UPLOAD_URL = '/uploads/settings/';

	public static $types = [
    	0 => '???????? ????????????', // inpyt type=text
    	1 => '?????????? ??????????', // textarea
    	2 => '??????????????', // ??????????????
        3 => '????????', // ????????
        4 => '?????????????????? ??????????', // ?????????????????????????? ????????????
        
        5 => '?????????????? ????????????', // ???????????? ??????????
        6 => '?????????????????????????? ????????????', // ???????????? ?? ??????????????????????
        7 => '?????????????? ??????????????????????', 
    ];

	public function group()
	{
		return $this->belongsTo('Fanky\Admin\Models\SettingGroup', 'group_id');
	}

	public function getValueAttribute($value)
	{
		switch ($this->type) {
            case 4:
            case 5:
            case 6:
            case 7:
                $json = json_decode($value, true);
                return is_array($json) ? $json : [];
                break;
            
            default:
                return $value;
                break;
        }
	}
}
