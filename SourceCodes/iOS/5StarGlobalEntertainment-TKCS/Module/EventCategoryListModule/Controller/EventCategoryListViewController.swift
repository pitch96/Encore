//
//  EventCategoryListViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 14/04/23.
//

import UIKit
import iOSDropDown
import SDWebImage

class EventCategoryListViewController: UIViewController {
    // MARK: - IBOutlets
    @IBOutlet weak var collectioViewEventCategory: UICollectionView!
    @IBOutlet weak var categoryList: DropDown!
    @IBOutlet weak var searchTextField: UITextField!
    @IBOutlet weak var lblNoRecord: UILabel!
    
    // MARK: - Variable initializer
    lazy var eventCategoryListViewModel:EventCategoryListViewModel = {
        var eventCategoryListViewModel = EventCategoryListViewModel()
        return eventCategoryListViewModel
    }()
    var manageListData : [ListDetails]?
    var searchListData : [ListDetails]?
    var manageCategoryData : [CategoryListDetails]?
    var filteredList : [ListDetails]?
    var changeDate = DateFormate()
    
    // MARK: - viewDidLoad
    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        collectioViewEventCategory.delegate = self
        collectioViewEventCategory.dataSource = self
        searchTextField.delegate = self
        callEventListApi()
        getCategoryList()
        categoryList.delegate = self
        categoryList.isUserInteractionEnabled = true
        
        categoryList.didSelect{(selectedText , index ,id) in
            self.categoryList.text = selectedText
            self.searchTextField.text = ""
            self.filteredList?.removeAll()
            switch index {
            case 0: self.filteredList = self.manageListData
                self.searchListData = self.filteredList
            default: self.filteredList = self.manageListData?.filter({[weak self] data in
                data.categoryID == self?.manageCategoryData?[index-1].id })
                self.searchListData = self.manageListData?.filter({[weak self] data in
                    data.categoryID == self?.manageCategoryData?[index-1].id })
            }
            self.collectioViewEventCategory.reloadData()
        }
    }

    // MARK: - Create function for Calling EventList Api
    func callEventListApi(){
        eventCategoryListViewModel.CallEventCategoryListApi {[weak self] data, isSuccess in
            if isSuccess == true{
                self?.manageListData = data.data
                self?.searchListData = data.data
                self?.filteredList = data.data
                if self?.manageListData?.count != nil{
                    self?.lblNoRecord.isHidden = true
                }else{
                    self?.lblNoRecord.isHidden = false
                }
                self?.collectioViewEventCategory.reloadData()
            }else{
                self?.showSimpleAlert(message: data.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Create function for get Category list
    func getCategoryList(){
        eventCategoryListViewModel.CallCategoryListApi {[weak self] CategoryData, isSuccess in
            if isSuccess == true{
                self?.manageCategoryData = CategoryData.data
                 if let nameList = self?.manageCategoryData?.map({$0.name}) as? [String] {
                     self?.categoryList.optionArray = nameList
                 }
                 if let nameList = self?.manageCategoryData?.map({$0.id}) as? [Int] {
                     self?.categoryList.optionIds = nameList
                 }
                self?.categoryList.optionArray.insert(DefaultValue.AllCategory.rawValue, at: 0)
                self?.categoryList.optionIds?.insert(0, at: 0)
            }else{
                self?.showSimpleAlert(message: CategoryData.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    // MARK: - Back Button Action
    // Create Function For navigate to previous screen
    // - Parameter sender: UIButton
    // return : nil
    @IBAction func backButtonAction(_ sender: Any) {
        self.navigationController?.popViewController(animated: true)
    }
    
}
// MARK: - Create extension for collection view Delegate and datasorce
extension EventCategoryListViewController: UICollectionViewDelegate, UICollectionViewDataSource, UICollectionViewDelegateFlowLayout{
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        if manageListData?.count == 0{
            lblNoRecord.isHidden = false
        }
        
        if filteredList?.count == 0{
            lblNoRecord.isHidden = false
        }else{
            lblNoRecord.isHidden = true
        }
        return filteredList?.count ?? 0
    }
    
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        let cell = collectionView.dequeueReusableCell(withReuseIdentifier: EventCategoryCollectionViewCell.identifier, for: indexPath) as! EventCategoryCollectionViewCell
        let data = filteredList?[indexPath.row]
        cell.EventTitle.text = data?.eventTitle ?? DefaultValue.emptyString.rawValue
        cell.lblAddress.text = (data?.venue ?? DefaultValue.emptyString.rawValue) + DefaultValue.space.rawValue + (data?.city ?? DefaultValue.emptyString.rawValue)
        let str1 = data?.startDate
        let str2 = data?.endDate
        let date = self.changeDate.getdate(strFirstDate: str1 ?? DefaultValue.emptyString.rawValue, strSecondDate: str2 ?? DefaultValue.emptyString.rawValue)
        cell.lblDate.text = date
        if let imageURL = data?.image{
            let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
            cell.eventImage.sd_imageIndicator = SDWebImageActivityIndicator.gray
            cell.eventImage.sd_setImage(with: URL(string: urlString)) { reqimage,err,_,url  in
            }
        }
        return cell
    }
    func collectionView(_ collectionView: UICollectionView, layout collectionViewLayout: UICollectionViewLayout, sizeForItemAt indexPath: IndexPath) -> CGSize {
        let collectionWidth = collectioViewEventCategory.bounds.size.width/2
        return CGSize(width: collectionWidth-10 , height: 120)
        
    }
    func collectionView(_ collectionView: UICollectionView, didSelectItemAt indexPath: IndexPath) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier:TicketViewController.identifier)as! TicketViewController
        vc.ticketID = searchListData?[indexPath.row].id ?? 0
        self.navigationController?.pushViewController(vc, animated: true)
        debugPrint(DefaultValue.emptyString.rawValue)
        self.collectioViewEventCategory.reloadData()
    }
}
// MARK: - Extention for TextFiled Delegate
extension EventCategoryListViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if let searchedText = searchTextField.text,
           let textRange = Range(range, in: searchedText){
            let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
            if updatedText != ""{
                filteredList =  searchListData?.filter({ values in
                    return (values.eventTitle ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                })
                
            } else {

               filteredList = searchListData
            }
            collectioViewEventCategory.reloadData()
        }
        return true
    }
    // MARK: - Create function for search on device return button
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
    // MARK: - Create function for avoid interaction form textfield
        func textFieldShouldBeginEditing(_ textField: UITextField) -> Bool
        {
            switch textField {
            case categoryList:
                return false
            default:
                return true
            }
        }
}
