<?php

use Illuminate\Database\Seeder;
//use App\BaomingAPI\BaomingAPI;
class BaomingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $selectSex = function($n){
            return ($n % 2 ? 'male' : 'female');
        };
        $writeBeizhu = function($n){
            if($n < 5){
                return '吴东牛逼啊！'.$n;
            }else{
                return null;
            }
        };

         for($i = 0; $i < 10; ++$i){
             \App\Baoming::create([
                 'name'      =>  'TestName'.$i,
                 'sex'       =>  $selectSex($i),
                 'phone'     =>  '123456'.$i,
                 'email'     =>  'TestEmail'.$i.'@email.com',
                 'xuehao'    =>  '2017000'.$i,
                 'college'   =>  'WD第'.$i.'牛逼学院',
                 'major'     =>  'WD第'.$i.'牛逼专业',
                 'beizhu'    =>  $writeBeizhu($i),
             ]);
         }
    }
}
