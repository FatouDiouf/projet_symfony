<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container7HBZVvO\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container7HBZVvO/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container7HBZVvO.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container7HBZVvO\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \Container7HBZVvO\srcApp_KernelDevDebugContainer([
    'container.build_hash' => '7HBZVvO',
    'container.build_id' => 'cc2b5b15',
    'container.build_time' => 1563035222,
], __DIR__.\DIRECTORY_SEPARATOR.'Container7HBZVvO');
