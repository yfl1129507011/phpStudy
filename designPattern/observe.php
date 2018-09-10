<?php
/**
 * Created by PhpStorm.
 * User: yfl
 * Date: 2018/9/10
 * Time: 15:00
 * 观察者模式
 */

# 被观察者
class Subject implements SplSubject{
    private $observers = array();

    // 添加观察者
    public function attach(SplObserver $observer)
    {
        // TODO: Implement attach() method.
        array_push($this->observers, $observer);
    }

    // 删除指定的观察者
    public function detach(SplObserver $observer)
    {
        // TODO: Implement detach() method.
        $key = array_search($observer, $this->observers);
        if(false !== $key){
            unset($this->observers[$key]);
        }
    }

    // 通知所有观察者
    public function notify()
    {
        // TODO: Implement notify() method.
        while(!empty($this->observers)){
            $observers = array_shift($this->observers);
            $observers->update($this);
        }
    }
}

# 观察者
class Observers1 implements SplObserver{
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        echo 'get notify one'.PHP_EOL;
    }
}

class Observers2 implements SplObserver{
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        echo 'get notify two'.PHP_EOL;
    }
}


# 被观察者
$subject = new Subject();
$observers1 = new Observers1();
$observers2 = new Observers2();
// 添加观察者
$subject->attach($observers1);
$subject->attach($observers2);
// 通知所有的观察者
//$subject->notify();
// 删除观察者
$subject->detach($observers1);
$subject->notify();
