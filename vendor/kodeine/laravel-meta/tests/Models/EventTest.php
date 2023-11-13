<?php

namespace Kodeine\Metable\Tests\Models;

use Kodeine\Metable\Metable;
use Illuminate\Events\Dispatcher;
use Kodeine\Metable\HasMetaEvents;
use Illuminate\Database\Eloquent\Model;
use Kodeine\Metable\Tests\Events\MetaSavedTestEvent;
use Kodeine\Metable\Tests\Events\MetaSavingTestEvent;
use Kodeine\Metable\Tests\Events\MetaCreatedTestEvent;
use Kodeine\Metable\Tests\Events\MetaUpdatedTestEvent;
use Kodeine\Metable\Tests\Events\MetaDeletedTestEvent;
use Kodeine\Metable\Tests\Events\MetaUpdatingTestEvent;
use Kodeine\Metable\Tests\Events\MetaDeletingTestEvent;
use Kodeine\Metable\Tests\Events\MetaCreatingTestEvent;

class EventTest extends Model
{
	use Metable, HasMetaEvents;
	
	public $listenersChanges = [];
	public $observersChanges = [];
	public $classListenersChanges = [];
	public $listenerShouldReturnFalse = [];
	public $observersShouldReturnFalse = [];
	public $classListenersShouldReturnFalse = [];
	
	protected $dispatchesEvents = [
		'metaCreating' => MetaCreatingTestEvent::class,
		'metaCreated' => MetaCreatedTestEvent::class,
		'metaSaving' => MetaSavingTestEvent::class,
		'metaSaved' => MetaSavedTestEvent::class,
		'metaUpdating' => MetaUpdatingTestEvent::class,
		'metaUpdated' => MetaUpdatedTestEvent::class,
		'metaDeleting' => MetaDeletingTestEvent::class,
		'metaDeleted' => MetaDeletedTestEvent::class,
	];
	
	public static function boot() {
		static::setEventDispatcher( new Dispatcher() );
		parent::boot();
		
		$listener = function (EventTest $model, $meta, $eventName) {
			if ( ! isset( $model->listenersChanges[$eventName] ) ) {
				$model->listenersChanges[$eventName] = [];
			}
			$model->listenersChanges[$eventName][] = $meta;
			if ( $model->listenerShouldReturnFalse[$eventName] ?? false ) {
				return false;
			}
		};
		
		static::metaCreating( function (EventTest $model, $meta) use ($listener) {
			return $listener( $model, $meta, 'metaCreating' );
		} );
		
		static::metaCreated( function (EventTest $model, $meta) use ($listener) {
			return $listener( $model, $meta, 'metaCreated' );
		} );
		
		static::metaSaving( function (EventTest $model, $meta) use ($listener) {
			return $listener( $model, $meta, 'metaSaving' );
		} );
		
		static::metaSaved( function (EventTest $model, $meta) use ($listener) {
			return $listener( $model, $meta, 'metaSaved' );
		} );
		
		static::metaUpdating( function (EventTest $model, $meta) use ($listener) {
			return $listener( $model, $meta, 'metaUpdating' );
		} );
		
		static::metaUpdated( function (EventTest $model, $meta) use ($listener) {
			return $listener( $model, $meta, 'metaUpdated' );
		} );
		
		static::metaDeleting( function (EventTest $model, $meta) use ($listener) {
			return $listener( $model, $meta, 'metaDeleting' );
		} );
		
		static::metaDeleted( function (EventTest $model, $meta) use ($listener) {
			return $listener( $model, $meta, 'metaDeleted' );
		} );
	}
}