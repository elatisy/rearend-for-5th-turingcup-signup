<?php namespace App\BaomingAPI;
use Illuminate\Support\Facades\DB;
use Excel;
class BaomingAPI{
    private $recv_arr;
    private $ret_arr = [];
    private $table = '360baomings';

    /**Private functions*/
    private function writeTable(){
        try {
            $temp = $this->recv_arr['college'];
            unset($this->recv_arr['college']);
            $this->recv_arr['college'] = $temp[0];
            $this->recv_arr['major']   = $temp[1];

            $phone  = DB::table($this->table)->where('phone','=',$this->recv_arr['phone'])->first();

            if ($phone != null){
                DB::table($this->table)->where('phone','=',$this->recv_arr['phone'])->update($this->recv_arr);
            }else{
                DB::table($this->table)->insert($this->recv_arr);
            }
        }catch (\Exception $e){
            $this->debugWriteLog('in writeTable'.$e->getMessage());
            $this->writeReturnMessage('1','write_table_error'.$e->getMessage());
        }
    }

    private function arr2json($arr){
        return json_encode($arr);
    }

    private function writeReturnMessage($code,$message){
        $this->ret_arr = array_merge($this->ret_arr,['code' => $code, 'message' => $message]);
    }

    private function debugWriteLog($info){
        $file_name = 'output.log';
        $File = fopen($file_name,'a');
        fwrite($File,$info."\n");
        fclose($File);

        $this->sc_send($info);
    }

    private function sc_send($info){
        $postdata = http_build_query(
            array(
                'text' => '主人主人,报名界面挂啦!',
                'desp' => '报错信息: '.$info,
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        return $result = file_get_contents('https://sc.ftqq.com/'.'masaike'.'.send', false, $context);
    }

    /**Public functions*/
    public function handle($recv){
        try {
            $this->recv_arr = $recv;
                $this->writeTable();
            if (!isset($this->ret_arr['code'])) {
                $this->writeReturnMessage('0', 'ok');
            }
        }catch (\Exception $e){
            $this->debugWriteLog('in handle'.$e->getMessage());
            $this->writeReturnMessage('1',$e->getMessage());
        }
        return $this->arr2json($this->ret_arr);
    }

    public function exportExcel($table_name, $name = '报名信息表', $title = ['name','phone','studentId','college','major'])
    {
        $table = DB::table($table_name)->get();

        $all_data[] = $title;

        foreach ($table as $signal_data){
            $temp = [];
            foreach ($title as $key){
                $temp[] = $signal_data->$key;
            }
            $all_data[] = $temp;
        }

        Excel::create($name,function($excel) use ($all_data){
            $excel->sheet('Sheet 1',function($sheet) use($all_data){
                $sheet->rows($all_data);
            });
        })->export('xls');

        return $name.'xls';
    }

};