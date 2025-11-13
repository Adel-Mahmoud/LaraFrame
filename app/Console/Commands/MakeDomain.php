<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeDomain extends Command
{
    protected $signature = 'make:domain {name : The name of the domain}
                            {--table : Generate migration table}
                            {--policy : Generate policy class}
                            {--repository : Generate repository class}
                            {--livewire : Generate livewire class}';

    protected $description = 'Create a new domain structure';

    public function handle(): void
    {
        $name = Str::pluralStudly($this->argument('name'));
        $className = Str::studly(Str::singular($this->argument('name'))) . 'Entity';
        $domainPath = app_path("Domains/{$name}");

        $this->createDirectoryStructure($domainPath);
        $this->createModel($domainPath, $name, $className);
        $this->createControllers($domainPath, $name, $className);
        $this->createRoutes($domainPath, $name, $className);
        $this->createViews($domainPath, $name);
        $this->createOptionalClasses($domainPath, $name, $className);

        $this->info("Domain {$name} created successfully.");
    }

    private function createDirectoryStructure(string $domainPath): void
    {
        $directories = [
            "{$domainPath}/Models",
            "{$domainPath}/Controllers/Web",
            "{$domainPath}/Controllers/Admin",
            "{$domainPath}/Routes",
            "{$domainPath}/Views/web",
            "{$domainPath}/Views/admin",
            "{$domainPath}/Database/Migrations",
        ];

        foreach ($directories as $dir) {
            File::ensureDirectoryExists($dir);
        }
    }

    private function createModel(string $domainPath, string $name, string $className): void
    {
        $modelPath = "{$domainPath}/Models/{$className}.php";
        
        if (!File::exists($modelPath)) {
            File::put($modelPath, $this->getModelStub($name, $className));
            $this->info("Model created: {$modelPath}");
        }
    }

    private function createControllers(string $domainPath, string $name, string $className): void
    {
        File::put("{$domainPath}/Controllers/Web/{$className}Controller.php", 
            $this->getControllerStub($name, $className, 'Web'));
        
        File::put("{$domainPath}/Controllers/Admin/{$className}Controller.php", 
            $this->getControllerStub($name, $className, 'Admin'));
    }

    private function createRoutes(string $domainPath, string $name, string $className): void
    {
        $lowercaseName = strtolower($name);
        $webRoutes = <<<PHP
        <?php
        
        use Illuminate\\Support\\Facades\\Route;
        
        Route::middleware('web')->prefix('{$lowercaseName}')->group(function () {
            Route::get('/', [App\\Domains\\{$name}\\Controllers\\Web\\{$className}Controller::class, 'index']);
        });
        PHP;

        $adminRoutes = <<<PHP
        <?php
        
        use Illuminate\\Support\\Facades\\Route;
        
        Route::middleware(['web','auth.admin'])->prefix('admin')->group(function () {
            Route::prefix('{$lowercaseName}')->group(function () {
                Route::get('/', [App\\Domains\\{$name}\\Controllers\\Admin\\{$className}Controller::class, 'index']);
            });
        });
        PHP;

        File::put("{$domainPath}/Routes/web.php", $webRoutes);
        File::put("{$domainPath}/Routes/admin.php", $adminRoutes);
    }

    private function createViews(string $domainPath, string $name): void
    {
        File::put("{$domainPath}/Views/web/index.blade.php", "<h1>{$name} Web Index</h1>");
        File::put("{$domainPath}/Views/admin/index.blade.php", "<h1>{$name} Admin Index</h1>");
    }

    private function createOptionalClasses(string $domainPath, string $name, string $className): void
    {
        if ($this->option('table')) {
            $this->createMigration($domainPath, $name);
        }

        if ($this->option('policy')) {
            $this->createPolicy($domainPath, $name, $className);
        }

        if ($this->option('repository')) {
            $this->createRepository($domainPath, $name, $className);
        }
    }

    private function createMigration(string $domainPath, string $name): void
    {
        $table = Str::snake($name);
        $timestamp = now()->format('Y_m_d_His');
        $migrationPath = "{$domainPath}/Database/Migrations/{$timestamp}_create_{$table}_table.php";

        File::put($migrationPath, $this->getMigrationStub($table));
        $this->info("Migration created: {$migrationPath}");
    }

    private function createPolicy(string $domainPath, string $name, string $className): void
    {
        $policyPath = "{$domainPath}/Policies/{$className}Policy.php";
        File::ensureDirectoryExists(dirname($policyPath));
        File::put($policyPath, $this->getPolicyStub($name, $className));
        $this->info("Policy created: {$policyPath}");
    }

    private function createRepository(string $domainPath, string $name, string $className): void
    {
        $repoPath = "{$domainPath}/Repositories/{$className}Repository.php";
        File::ensureDirectoryExists(dirname($repoPath));
        File::put($repoPath, $this->getRepositoryStub($name, $className));
        $this->info("Repository created: {$repoPath}");
    }

    protected function getModelStub(string $name, string $className): string
    {
        return <<<PHP
        <?php

        namespace App\\Domains\\{$name}\\Models;

        use Illuminate\\Database\\Eloquent\\Model;

        class {$className} extends Model
        {
            protected \$guarded = [];
        }
        PHP;
    }

    protected function getControllerStub(string $name, string $className, string $type): string
    {
        $viewNamespace = strtolower($name) . '::' . strtolower($type) . '.index';

        return <<<PHP
        <?php

        namespace App\\Domains\\{$name}\\Controllers\\{$type};

        use App\\Http\\Controllers\\Controller;

        class {$className}Controller extends Controller
        {
            public function index()
            {
                return view('{$viewNamespace}');
            }
        }
        PHP;
    }

    protected function getMigrationStub(string $table): string
    {
        return <<<PHP
        <?php

        use Illuminate\\Database\\Migrations\\Migration;
        use Illuminate\\Database\\Schema\\Blueprint;
        use Illuminate\\Support\\Facades\\Schema;

        return new class extends Migration
        {
            public function up(): void
            {
                Schema::create('{$table}', function (Blueprint \$table) {
                    \$table->id();
                    \$table->string('name');
                    \$table->timestamps();
                });
            }

            public function down(): void
            {
                Schema::dropIfExists('{$table}');
            }
        };
        PHP;
    }

    protected function getPolicyStub(string $name, string $className): string
    {
        return <<<PHP
        <?php

        namespace App\\Domains\\{$name}\\Policies;

        use App\\Models\\User as AuthUser;
        use App\\Domains\\{$name}\\Models\\{$className};

        class {$className}Policy
        {
            public function view(AuthUser \$user, {$className} \$model): bool
            {
                return true;
            }

            public function create(AuthUser \$user): bool
            {
                return true;
            }

            public function update(AuthUser \$user, {$className} \$model): bool
            {
                return true;
            }

            public function delete(AuthUser \$user, {$className} \$model): bool
            {
                return true;
            }
        }
        PHP;
    }

    protected function getRepositoryStub(string $name, string $className): string
    {
        return <<<PHP
        <?php

        namespace App\\Domains\\{$name}\\Repositories;

        use App\\Domains\\{$name}\\Models\\{$className};

        class {$className}Repository
        {
            public function all()
            {
                return {$className}::all();
            }

            public function find(\$id)
            {
                return {$className}::find(\$id);
            }

            public function create(array \$data)
            {
                return {$className}::create(\$data);
            }

            public function update(\$id, array \$data)
            {
                \$model = {$className}::findOrFail(\$id);
                \$model->update(\$data);
                return \$model;
            }

            public function delete(\$id)
            {
                return {$className}::destroy(\$id);
            }
        }
        PHP;
    }
}