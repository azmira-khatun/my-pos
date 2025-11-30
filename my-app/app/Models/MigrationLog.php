<?PHP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrationLog extends Model
{
    use HasFactory;

    // *** ESSENTIAL CHANGE: Link the Model to the official 'migrations' table ***
    protected $table = 'migrations';
    // *************************************************************************

    // Define the fillable fields (matching the table columns)
    protected $fillable = [
        'migration',
        'batch',
    ];

    // The 'migrations' table typically doesn't use standard 'created_at' and 'updated_at' timestamps
    public $timestamps = false;
}