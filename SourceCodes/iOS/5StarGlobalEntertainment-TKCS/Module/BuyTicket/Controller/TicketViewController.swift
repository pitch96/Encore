//
//  TicketViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/12/22.
//

import UIKit

class TicketViewController: UIViewController {

    @IBOutlet weak var lblStartDate: UILabel!
    @IBOutlet weak var lblStartTime: UILabel!
    @IBOutlet weak var lblEndDate: UILabel!
    @IBOutlet weak var lblEndTime: UILabel!
    @IBOutlet weak var lblPerheadPrice: UILabel!
    @IBOutlet weak var lblTotalPrice: UILabel!
    @IBOutlet weak var btnDecrease: UIButton!
    @IBOutlet weak var btnIncrease: UIButton!
    
    var ticketViewModel = TicketViewModel()
    var tickeObject : TicketModel?
    var ticket = [TicketModel]()
    var totalAmount = 0
    
    override func viewDidLoad() {
        super.viewDidLoad()
//        ticketViewModel.CallTicketApi(eventId: 46) { ticketData, isSuccess in
//            if ticketData.success == true{
//                print(ticketData.data?[1].quantity)
//            }else{
//                print("Data not found")
//            }
//        }
        
        // Do any additional setup after loading the view.
    btnIncrease.addTarget(self, action: #selector(increase(_:)), for: .touchUpInside)
    btnDecrease.addTarget(self, action: #selector(decrease(_:)), for: .touchUpInside)
       
        
    }
    override var preferredStatusBarStyle: UIStatusBarStyle {
        return .lightContent
    }
    @objc func decrease(_ sender:UIButton){
//        if ticket[sender.tag]
        
    }
    @objc func increase(_ sender:UIButton){
        
    }
   
    
    func setTotalAmount(){
      
    
   }
    
    @IBAction func btnBuyTicket(_ sender: Any) {
    
    }
    
    @IBAction func buttonBcak(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
}
