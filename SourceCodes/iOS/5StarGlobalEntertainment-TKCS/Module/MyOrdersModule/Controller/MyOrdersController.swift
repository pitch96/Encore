//
//  MyOrdersController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/12/22.
//

import UIKit

class MyOrdersController: UIViewController {
    // MARK: IBOUTLET
    @IBOutlet weak var myOrderstableView: UITableView!
    @IBOutlet weak var lblNoRecord: UILabel!
    @IBOutlet weak var backButton: UIButton!
    
    // MARK: - VARIABLES
    var myOrderViewModel = MyOrderViewModel()
    var orderModel: [OrderDetail]?
    
    override func viewDidLoad() {
        super.viewDidLoad()
        self.setCustomUI()
        //callOrderHistoryAPI()
        let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
        debugPrint(UserDefaults.standard.value(forKey:Tokenkey.UsersTypes) ?? 0)
        switch userType {
        case 1:
            backButton.isHidden = false
        case 2:
            backButton.isHidden = true
        case 3:
            backButton.isHidden = false
            
        default:
            break
        }
    }
    // MARK: order Api Call--
    override func viewWillAppear(_ animated: Bool) {
        callOrderHistoryAPI()
        
    }
    
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    // MARK: Create function for calling my Order api--
    private func callOrderHistoryAPI(){
        myOrderViewModel.callOrderDetailApi { [weak self] orderDeatilData, isSuccess in
            if isSuccess == true{
                self?.orderModel = orderDeatilData?.data?.reversed()
                self?.myOrderstableView.reloadData()
            }else{
                self?.showSimpleAlert(message: orderDeatilData?.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
        
    }
    
    
}
