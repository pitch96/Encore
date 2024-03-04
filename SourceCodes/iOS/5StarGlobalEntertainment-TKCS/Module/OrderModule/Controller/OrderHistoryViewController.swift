//
//  OrderHistoryViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/03/23.
//

import UIKit
import SDWebImage

class OrderHistoryViewController: UIViewController {
// MARK: IBOutlets--
    @IBOutlet weak var tableViewOrderHistory: UITableView!
    @IBOutlet weak var searchTextField: UITextField!
    @IBOutlet weak var lblNoRecord: UILabel!
    @IBOutlet weak var lblPayout: UILabel!
    // MARK: Variable Initializer--
    var orderHistoryModel = OrderHistoryModel()
    lazy var orderHistoryViewModel:OrderHistoryViewModel = {
        var orderHistoryViewModel = OrderHistoryViewModel()
        return orderHistoryViewModel
    }()
    var manageOrderData: [DataModelResponse]?
    var searchOrderData: [DataModelResponse]?
    // MARK: viewDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        tableViewOrderHistory.delegate = self
        tableViewOrderHistory.dataSource = self
        searchTextField.delegate = self
        OrderHistory()
        lblNoRecord.isHidden = true
        tableViewOrderHistory.reloadData()
        let userType = (UserDefaults.standard.value(forKey: Tokenkey.UsersTypes) as? Int) ?? 0
        switch userType {
        case 1:
            self.lblPayout.isHidden = false
        case 2:
            self.lblPayout.isHidden = true
        case 3:
            self.lblPayout.isHidden = false
        default:
            break
        }
        callPayoutAPI()
    }
    // MARK: Create func for calling Order history Api call-
    func OrderHistory(){
        orderHistoryViewModel.callOrderHistoryApi {[weak self] data, isSuccess in
            if isSuccess == true{
                self?.manageOrderData = data.data
                self?.searchOrderData = data.data
                self?.tableViewOrderHistory.reloadData()
            }else{
                self?.showSimpleAlert(message: data.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Create function for calling Payout Api
    func callPayoutAPI(){
        orderHistoryViewModel.callPayoutApi {[weak self] payoutData, isSuccess in
            if isSuccess == true{
                if payoutData.data?.totalPayout ?? 0 < 1{
                    self?.lblPayout.text = "Total Payouts($):- $\(0.00)"
                }else{
                    self?.lblPayout.text = "Total Payouts($):- $\(payoutData.data?.totalPayout ?? 0)"
                }
            }else{
                self?.showSimpleAlert(message: payoutData.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Back Button Action
    ///Create action for navigate to previous screen
    /// - Parameter sender: UIButton
    /// return : nil
    @IBAction func backActionButton(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
}
// MARK: - Create extension for tableview delegate and dataSource
extension OrderHistoryViewController: UITableViewDelegate, UITableViewDataSource{
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if searchOrderData?.count == 0{
            lblNoRecord.isHidden = false
        }else{
            lblNoRecord.isHidden = true
        }
        return searchOrderData?.count ?? 0
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: OrderHistoryTableViewCell.identifier, for: indexPath) as! OrderHistoryTableViewCell
        let data = searchOrderData?[indexPath.row]
        cell.lblEventTitle.text = data?.orderDetails?.eventTitle?.capitalized
        cell.lblPrice.text = "PR:- $\(data?.orderDetails?.totalPrice ?? 0)"
        cell.lblOrderDate.text = "Date:- \(data?.orderPlacedDate ?? DefaultValue.emptyString.rawValue)"
        cell.lblTicketType.text = data?.orderDetails?.ticketType
        cell.lblTicketTitle.text = data?.orderDetails?.ticketTitle?.capitalized
        cell.lblUserName.text = data?.user?.fullName
        cell.lblQuantity.text = "Qty:- \(data?.orderDetails?.ticketPurchaseQty ?? 0)"
        if let imageURL = data?.orderDetails?.eventImage{
            let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
            cell.imageEvent.sd_imageIndicator = SDWebImageActivityIndicator.gray
            cell.imageEvent.sd_setImage(with: URL(string: urlString)) { reqimage,err,_,url  in
            }
        }
       

        return cell
    }
}
// MARK: Extention for TextFiled Delegate--
///create function for seach data on basis of text--
extension OrderHistoryViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if let searchedText = searchTextField.text,
           let textRange = Range(range, in: searchedText){
            let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
            if updatedText != ""{
                searchOrderData = manageOrderData?.filter({ values in
                    return (values.orderDetails?.eventTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.user?.fullName ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) || (values.orderDetails?.ticketTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased()) ||
                    (values.orderDetails?.ticketType ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                })
            }else{
                searchOrderData = manageOrderData
            }
            tableViewOrderHistory.reloadData()
        }
        return true
    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}
